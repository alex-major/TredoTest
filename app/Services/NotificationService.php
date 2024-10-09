<?php

namespace App\Services;

use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Messaging\CloudMessage;

use App\Models\User;
use App\Models\History;

class NotificationService {
	public function send(array $notification) {
		$sender = Firebase::messaging();
		
		foreach(User::All() as $user) {
			History::create([
				'user_id' => $user->id;
				'notification_id' => $notification->id;
				'status' => 'send';
			]);
				
			$message = CloudMessage::fromArray([
			  'token' => $user->userDevice()->fcm_token,
			  'notification' => [
				'title' => $notification->title,
				 'body' => $notification->body
				],
			 ]);

			$response = $sender->send($message);
			
			if(!empty($response)) {
				History::create([
					'user_id' => $user->id;
					'notification_id' => $notification->id;
					'status' => 'sended';
				]);
			} else {
				History::create([
					'user_id' => $user->id;
					'notification_id' => $notification->id;
					'status' => 'error';
				]);
			}
		}
	}
}