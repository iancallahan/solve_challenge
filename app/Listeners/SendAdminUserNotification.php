<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Notifications\NewUser;
use App\User;
use Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAdminUserNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        $users = User::whereHas('hasAdmin')->get();
        Notification::send($users, new NewUser($event->user));
    }
}
