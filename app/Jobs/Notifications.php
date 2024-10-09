<?php

namespace App\Jobs;

use App\Model\Notification;
use App\Services\NotificationService;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class Notifications implements ShouldQueue
{
    use Queueable;
	
	private Notification $notifications;

    /**
     * Create a new job instance.
     */
    public function __construct(public Notification $notifications)
    {
        $this->notifications = $notifications;
    }

    /**
     * Execute the job.
     */
    public function handle(NotificationService $service): void
    {
		$notifications = $this->notifications
			->where('day(send_at)','=',DB::raw('day'(now())))
			->where('time(send_at)','>=',DB::raw('time'(now())))
			->where('status','!=','sended')
			->get();
		
		foreach($notifications as $notification) {
			$service->send($this->notification);
		}
    }
}
