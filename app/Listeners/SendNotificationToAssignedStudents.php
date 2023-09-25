<?php

namespace App\Listeners;

use App\Events\ClassworkUpdated;
use App\Models\User;
use App\Notifications\NewClassworkNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNotificationToAssignedStudents
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle($event): void
    {
        // $user = (User::find(1));
        // $user->notify(new NewClassworkNotification($event->classwork));

        // foreach($event->classwork->users as $user){
        //     $user->notify(new NewClassworkNotification($event->classwork));
        // }


        Notification::send($event->classwork->classroom->users, new NewClassworkNotification($event->classwork));
    }
}
