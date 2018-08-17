<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password', 'avatar',
	];

	// *
	//  * The attributes that should be hidden for arrays.
	//  *
	//  * @var array

	protected $hidden = [
		'password', 'remember_token',
	];

	// protected $table = 'users';

	/**
	 * A user can have many messages
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function messages() {
		return $this->hasMany(Message::class);
	}

	public function friends() {
		return $this->hasMany(Friend::class, 'id', 'user_id');
	}
	public function statuss() {
		return $this->hasMany(Status::class, 'id', 'user_id');
	}
}
