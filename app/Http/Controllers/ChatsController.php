<?php

namespace App\Http\Controllers;
use App\Events\MessageSent;
use App\Friend;
use App\Group;
use App\Message;
use App\MessageRecipient;
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

	public function loadFriend(Request $request) {
		// $user_id = $request->input('user_id');
		$group_id = $request->input('group_id');
		$user_in_group = UserGroup::select('user_id')->where('group_id', $group_id)->get();
		$listfriends_not_group = Friend::with('user')
			->where(['user_id' => Auth::user()->id, 'status' => 'OK'])
			->whereNotIn('friend_id', $user_in_group)
			->get();
		return response()->json([
			'friends' => $listfriends_not_group,
		]);
	}

	public function createGroup(Request $request) {
		$user_id1 = Auth::user()->id;
		// $user_id1 = $request->input('user_id_1');
		$user_id2 = $request->input('user_id_2');
		$name = $request->input('name');

		$date = new \DateTime();
		$now = $date->format('Y') . $date->format('m') . $date->format('d') . $date->format('H') . $date->format('i') . $date->format('s') . $date->format('u');

		Group::create([
			'group_id' => $now,
			'name' => $name,
		]);

		UserGroup::create([
			'user_id' => $user_id1,
			'group_id' => $now,
		]);

		UserGroup::create([
			'user_id' => $user_id2,
			'group_id' => $now,
		]);

		return Response()->json([
			'notification' => 'Successfully!',
		]);

		return Response()->json([
			'notification' => 'Fail!',
		]);

	}

	public function addMemGroup(Request $request) {
		$user_id_add = $request->input('id_member');
		$group_id = $request->input('group_id');
		if ($user_id_add == 0) {
			$user_add = $request->input('user_add');
			$user_id_add = User::where('name', $user_add)->first();
			$credentials = [
				'user_id' => $user_id_add->id,
				'group_id' => $group_id,
			];
		} else {
			$credentials = [
				'user_id' => $user_id_add,
				'group_id' => $group_id,
			];
		}
		if (UserGroup::where($credentials)->count() == 0) {
			UserGroup::create($credentials);
			return Response()->json([
				'notification' => 'Add Successfully!',
			]);
		} else {
			return Response()->json([
				'notification' => 'User already exist in group!',
			]);
		}

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

		$users = User::join('users_group', 'users_group.user_id', '=', 'users.id')
			->join('groups', 'groups.id', '=', 'users_group.group_id')
			->select('users.*')
			->where(['groups.id' => $recipient_group_id])->get();

		foreach ($users as $item) {
			broadcast(new MessageSent($user, $message, $item->id))->toOthers();
		}

		return Response()->json([
			'user' => $user,
			'message' => $message,
		]);
	}
}
