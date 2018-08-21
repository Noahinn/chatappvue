<?php

namespace App\Http\Controllers;
use App\Friend;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {
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
	public function index() {

		// note
		$friends = Friend::with('user')->where('user_id', Auth::user()->id)->get();
		//print_r($friends);
		$friend_ids = array();
		foreach ($friends as $friend) {
			array_push($friend_ids, $friend->user->id);
		}
		array_push($friend_ids, Auth::user()->id);
		$listfriends = Friend::with('user')->where(['user_id' => Auth::user()->id, 'status' => 'OK'])->get();
		$users = User::whereNotIn('id', $friend_ids)->get();

		$listgroups = User::join('users_group', 'users_group.user_id', '=', 'users.id')
			->join('groups', 'groups.id', '=', 'users_group.group_id')
			->select('users.*', 'groups.*')
			->where(['user_id' => Auth::user()->id])->get();
		return view('home', array(
			'users' => $users,
			'friends' => $listfriends,
			'listgroups' => $listgroups));
	}

	//search user in users table
	public function search(Request $request) {
		$user_name = $request->name;
		$flights = User::select('name', 'email', 'id')->where('name', 'like', '%' . $user_name . '%')->get();
		// List friends
		$friends = Friend::with('user')->where(['user_id' => Auth::user()->id, 'status' => 'OK'])
			->get();
		$friend_list = array();
		foreach ($friends as $friend) {
			array_push($friend_list, $friend->user->name);
		}
		// List waiting
		$friends = Friend::with('user')->where(['user_id' => Auth::user()->id, 'status' => 'send'])
			->get();
		$friend_wait = array();
		foreach ($friends as $friend) {
			array_push($friend_wait, $friend->user->name);
		}
		// List request
		$friends = Friend::with('user')->where(['user_id' => Auth::user()->id, 'status' => 'send'])
			->get();
		$friend_req = array();
		foreach ($friends as $friend) {
			array_push($friend_req, $friend->user->name);
		}
		return view('search', array('users' => $flights, 'friends' => $friend_list, 'friend_wait' => $friend_wait, 'friend_req' => $friend_req));
	}
}
