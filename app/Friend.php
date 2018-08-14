<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model {

	/**
	 * Fields that are mass assignable
	 *
	 * @var array
	 */
	protected $table = 'friends';

	/**
	 * A message belong to a user
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user() {
		return $this->belongsTo(User::class, 'friend_id', 'id');
	}
}
