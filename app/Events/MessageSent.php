<?php

namespace App\Events;
use App\Message;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast {
	use Dispatchable, InteractsWithSockets, SerializesModels;

	/**
	 * User that sent the message
	 *
	 * @var User
	 */
	public $user;

	/**
	 * Message details
	 *
	 * @var Message
	 */
	public $message;
	public $room_id;
	public $friend_id;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(User $user, Message $message, $recipient_id) {
		$this->user = $user;
		$this->message = $message;
		$this->friend_id = $recipient_id;
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return Channel|array
	 */
	public function broadcastOn() {
		// $room = Session::get('room');
		return new Channel((string) $this->friend_id);
	}

}