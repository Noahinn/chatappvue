<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model {

	/**
	 * Fields that are mass assignable
	 *
	 * @var array
	 */
	protected $table = 'groups';
	protected $fillable = ['name'];

	/**
	 * A message belong to a user
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function UserGroup() {
		return $this->hasMany(UserGroup::class, 'id', 'group_id');
	}

	public function MessageRec() {
		return $this->hasMany(MessageRecipient::class, 'id', 'recipient_group_id');
	}

}