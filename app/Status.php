<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model {

	/**
	 * Fields that are mass assignable
	 *
	 * @var array
	 */
	protected $table = 'status';

	/**
	 * A message belong to a user
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user() {
		return $this->belongsTo(User::class);
	}
}