<?php

namespace App\Http\Controllers;
use App\Events\MessageSent;
use App\Message;
use App\Room;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Redirect;
use Session;

class ChatsController extends Controller {
	//
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Show chats
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view('chat');
	}

	public function room($room) {
		Session::put('room', $room);
		if ($room == "all") {
			echo Auth::user()->id;
			$users = DB::select('select * from users');
			return view('home', ['users' => $users]);
		}
		if ($room != 'all') {

			$credentials = [
				"id" => $room,
				"user_id" => Auth::user()->id,
			];

			//Split room
			$pieces = explode("-", $room);

			if (DB::table('rooms')->where($credentials)->count() == 1) {
				return view('chat', ['room' => $room]);
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
			return view('chat', ['room' => $room]);
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

		$message = $user->messages()->create([
			'message' => $request->input('message'),
			'room_id' => Session::get('room'),
		]);

		broadcast(new MessageSent($user, $message, Session::get('room')))->toOthers();

		return ['status' => 'Message Sent!'];
	}
}
