<?php

namespace App\Http\Controllers;
use App\Events\MessageSent;
use App\Group;
use App\Message;
use App\MessageRecipient;
use App\Room;
use App\User;
use App\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class ChatsController extends Controller {
	//
	// public function __construct() {
	// 	$this->middleware('auth');
	// }

	/**
	 * Show chats
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view('chat');
	}

// NOT USED
	public function room(Request $request) {
		$id = $request->id;
		if (Auth::user()->id <= $id) {
			$room = 'room-' . Auth::user()->id . '-' . $id;
		} else {
			$room = 'room-' . $id . '-' . Auth::user()->id;
		}

		Session::put('room', $room);

		if ($room != 'all') {
			$credentials = [
				"id" => $room,
				"user_id" => Auth::user()->id,
			];

			//Split room
			$pieces = explode("-", $room);

			if (Room::where($credentials)->count() == 1) {
				$messages = Message::with('user')->where('room_id', Session::get('room'))
					->get();
				// return view('chat', array('room' => $room, 'messages' => $messages));
				return response()->json([
					'messages' => $messages,
					'room' => $room,
				]);
			} else {
				if (Auth::user()->id != $pieces[1] && Auth::user()->id != $pieces[2]) {
					return Redirect::to('/');
				}
				//Create new room with user 1
				$rooms = new Room;
				$rooms->id = $room;
				$rooms->user_id = $pieces[1];
				$rooms->save();
				if ($pieces[2] != $pieces[1]) {
					//Create new room with user 2
					$rooms = new Room;
					$rooms->id = $room;
					$rooms->user_id = $pieces[2];
					$rooms->save();
				}
			}
			return Response()->json([
				'room' => $room,
			]);
		}
	}

	public function createGroup(Request $request) {
		$user_id1 = Auth::user()->id;
		$user_id2 = $request->input('user_id_2');
		$name = $request->input('name');

		$date = new \DateTime();
		$now = $date->format('Y') . $date->format('m') . $date->format('d') . $date->format('H') . $date->format('i') . $date->format('s') . $date->format('u');
		// $que->id = $now;

		Group::create([
			'group_id' => $now,
			'name' => $name,
		]);

		$group_ids = Group::orderBy('id', 'asd')->where('name', $name)->first();

		UserGroup::create([
			'user_id' => $user_id1,
			'group_id' => $group_ids->id,
		]);

		UserGroup::create([
			'user_id' => $user_id2,
			'group_id' => $group_ids->id,
		]);

		return Response()->json([
			'notification' => 'Successfully!',
		]);

	}

	public function addMemGroup(Request $request) {
		$group_id = $request->input('group_id');
		$user_id = $request->input('user_id');

		UserGroup::create([
			'user_id' => $user_id,
			'group_id' => $group_id,
		]);

		return Response()->json([
			'user_id' => $user_id,
			'group_id' => $group_id,
		]);

	}

	public function loadMessages(Request $request) {
		// $user_id = $request->input('user_id');
		$user_id = Auth::user()->id;
		$recipient_id = $request->input('recipient_id');

		if ($user_id <= $recipient_id) {
			$con_id = (string) $user_id . 'p' . (string) $recipient_id;
		} else {
			$con_id = (string) $recipient_id . 'p' . (string) $user_id;
		}

		$messages = User::join('messages', 'messages.user_id', '=', 'users.id')
			->join('messages_recipient', 'messages_recipient.message_id', '=', 'messages.id')
			->select('users.*', 'messages.*')
			->where(['con_id' => $con_id])->get();

		return Response()->json([
			'messages' => $messages,
		]);
	}

	public function loadMessagesGroup(Request $request) {
		// $user_id = $request->input('user_id');
		// $user_id = Auth::user()->id;
		$recipient_group_id = $request->input('group_id');
		$con_id = 'g' . $recipient_group_id;

		$messages = User::join('messages', 'messages.user_id', '=', 'users.id')
			->join('messages_recipient', 'messages_recipient.message_id', '=', 'messages.id')
			->select('users.*', 'messages.*')
			->where(['con_id' => $con_id])->get();

		return Response()->json([
			'messages' => $messages,
		]);
	}
	/**
	 * Fetch all messages
	 *
	 * @return Message
	 */
	public function fetchMessages() {
		$messages = Message::with('user')->where('room_id', Session::get('room'))
			->get();
		return $messages;
	}

	public function sendMessage(Request $request) {
		$user = Auth::user();
		// $user_id = $request->input('user_id');
		$user_id = $user->id;
		$recipient_id = $request->input('recipient_id');
		$mess = $request->input('textmess');

		if ($user_id <= $recipient_id) {
			$con_id = $user_id . 'p' . $recipient_id;
		} else {
			$con_id = $recipient_id . 'p' . $user_id;
		}

		$message = Message::create([
			'user_id' => $user_id,
			'message' => $mess,
			'con_id' => $con_id,
		]);

		$message_id = Message::orderBy('id', 'asd')->first();

		$messageRecipient = MessageRecipient::create([
			'recipient_id' => $recipient_id,
			'message_id' => $message_id->id,
		]);

		broadcast(new MessageSent($user, $message, $recipient_id))->toOthers();

		return Response()->json([
			'user' => $user,
			'message' => $message,
		]);
	}

	public function sendMessageGroup(Request $request) {
		$user = Auth::user();
		// $user_id = $request->input('user_id');
		$user_id = $user->id;
		$recipient_group_id = $request->input('group_id');
		$mess = $request->input('textmess');
		$con_id = 'g' . $recipient_group_id;

		$message = Message::create([
			'user_id' => $user_id,
			'message' => $mess,
			'con_id' => $con_id,
		]);

		$message_id = Message::orderBy('id', 'asd')->first();
		$namegroup = Group::where('id', $recipient_group_id)->first();
		$messageRecipient = MessageRecipient::create([
			'recipient_group_id' => $recipient_group_id,
			'message_id' => $message_id->id,
		]);
		$channel_id = 'g' . $recipient_group_id;

		broadcast(new MessageSent($user, $message, $namegroup->name))->toOthers();

		// return Response()->json([
		// 	'user_id' => $user_id,
		// 	'recipient_group_id' => $recipient_group_id,
		// 	'message_id' => $message_id->id,
		// ]);
		return Response()->json([
			'user' => $user,
			'message' => $message,
		]);
	}
}
