<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model {

	/**
	 * Fields that are mass assignable
	 *
	 * @var array
	 */
	protected $table = 'users_group';
	protected $fillable = ['user_id', 'group_id'];

	/**
	 * A message belong to a user
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user() {
		return $this->belongsTo(User::class);
	}
}