<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageRecipient extends Model {

	/**
	 * Fields that are mass assignable
	 *
	 * @var array
	 */
	protected $table = 'messages_recipient';
	protected $fillable = ['recipient_id', 'message_id', 'recipient_group_id'];

	/**
	 * A message belong to a user
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user() {
		return $this->belongsTo(User::class);
	}
	public function message() {
		return $this->belongsTo(Message::class, 'message_id', 'id');
	}
}