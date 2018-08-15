<?php

namespace App\Http\Controllers;
use App\Friend;
use App\User;
use DB;
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
		//$users = DB::select('select * from users');
		$friends = Friend::with('user')->where('user_id', Auth::user()->id)
			->get();
		//print_r($friends);
		$friend_ids = array();
		foreach ($friends as $friend) {
			array_push($friend_ids, $friend->user->id);
		}
		array_push($friend_ids, Auth::user()->id);
		$users = DB::table('users')
			->whereNotIn('id', $friend_ids)->get();
		return view('home', array('users' => $users, 'friends' => $friends));
	}

	//search user in users table
	public function search(Request $request) {
		$user_name = $request->name;
		$flights = User::select('name', 'email', 'id')->where('name', 'like', '%' . $user_name . '%')->get();
		$friends = Friend::with('user')->where(['user_id' => Auth::user()->id, 'status' => 'OK'])
			->get();
		return view('search', array('users' => $flights, 'friends' => $friends));
	}
}
