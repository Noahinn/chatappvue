<?php

namespace App\Http\Controllers;
use App\Friend;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */

	//add friend
	// status = 0 -> waiting response
	private function saveToDB($user_id, $friend_id, $status) {
		$friends = new Friend;
		$friends->user_id = $user_id;
		$friends->friend_id = $friend_id;
		$friends->status = $status;
		$friends->save();
	}

	public function add(Request $request) {
		$friend_id = $request->id;
		$user_id = Auth::user()->id;
		$credentials = [
			"user_id" => $user_id,
			"friend_id" => $friend_id,
		];
		if (Friend::where($credentials)->count() == 1 || $user_id == $friend_id) {
			return view('/');
		} else {
			$this->saveToDB($user_id, $friend_id, 'send');
			$this->saveToDB($friend_id, $user_id, 'receiver');
		}
		return response()->json([
			'nofication' => 'Sent Request',
		]);
	}

	public function accept(Request $request) {
		$user_id = Auth::user()->id;
		$friend_id = $request->id;
		$result1 = Friend::where(['user_id' => $user_id, 'friend_id' => $friend_id])->update(['status' => 'OK']);
		$result2 = Friend::where(['user_id' => $friend_id, 'friend_id' => $user_id])->update(['status' => 'OK']);
		return response()->json([
			'nofication' => 'Successfully!',
		]);
	}

	// delete friend
	public function delete(Request $request) {
		$user_id = Auth::user()->id;
		$friend_id = $request->id;

		$deletedRow1 = Friend::where(['user_id' => $user_id, 'friend_id' => $friend_id])->delete();
		$deletedRow2 = Friend::where(['user_id' => $friend_id, 'friend_id' => $user_id])->delete();

		return response()->json([
			'nofication' => 'Delete Successfully!',
		]);
	}

	public function profile() {
		$friends = Friend::with('user')->where(['user_id' => Auth::user()->id, 'status' => 'OK'])
			->get();
		//get user Co friend_id = Auth::user()->id
		$friends_wait = Friend::with('user')->where(['user_id' => Auth::user()->id, 'status' => 'receiver'])->get();
		$friends_send = Friend::with('user')->where(['user_id' => Auth::user()->id, 'status' => 'send'])->get();
		// return response()->json([
		// 	'friends_wait' => $friends_wait,
		// ]);
		return view('profile', [
			'friends_wait' => $friends_wait,
			'friends' => $friends,
			'friends_send' => $friends_send,
		]);
	}

}
