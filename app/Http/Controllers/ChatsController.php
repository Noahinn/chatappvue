<?php

namespace App\Http\Controllers;
use App\Events\MessageSent;
use App\Message;
use App\Room;
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
		// Session::put('room', $room);
		// if ($room == "all") {
		// 	echo Auth::user()->id;
		// 	$users = DB::select('select * from users');
		// 	return view('home', ['users' => $users]);
		// }
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

	public function loadMessages(Request $request) {
		$user_id = Auth::user()->id;
		$recipient_id = $request->input('recipient_id');
		if ($user_id <= $recipient_id) {
			$con_id = (string) $user_id . (string) $recipient_id;
		} else {
			$con_id = (string) $recipient_id . (string) $user_id;
		}

		if (Message::where('con_id', $con_id)->count() > 0) {
			$messages = Message::with('user')->where('con_id', $con_id)->get();
			return response()->json([
				'messages' => $messages,
			]);
		} else {
			return Response()->json([
				'notification' => 'not messages',
			]);
		}

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

	/**	 * Fetch all messages
	 * Persist message to database
	 *
	 * @param  Request $request
	 * @return Response
	 */
	public function sendMessage(Request $request) {
		$user = Auth::user();
		$user_id = $user->id;
		$recipient_id = $request->input('recipient_id');
		$mess = $request->input('textmess');

		if ($user_id <= $recipient_id) {
			$con_id = $user_id . $recipient_id;
		} else {
			$con_id = $recipient_id . $user_id;
		}

		$message = Message::create([
			'user_id' => $user_id,
			'message' => $mess,
			'recipient_id' => $recipient_id,
			'con_id' => $con_id,
		]);

		broadcast(new MessageSent($user, $message))->toOthers();

		return Response()->json([
			'user' => $user,
			'message' => $message,
		]);
	}
}
