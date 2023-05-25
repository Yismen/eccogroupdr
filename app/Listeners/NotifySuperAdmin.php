<?php

namespace App\Listeners;

use App\Services\AppSuperUsers;
use App\Mail\NotifySuperAdminEmail;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;

class NotifySuperAdmin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(Registered|Verified $event): void
    {
        $user = $event->user;
        $superUsersService = new AppSuperUsers();

        $title = match (true) {
            $event instanceof Registered => 'User Registered',
            $event instanceof Verified => 'User Completed Account Verification',
        };

        Mail::to($superUsersService->get())
            ->send(new NotifySuperAdminEmail($title, $user));
    }
}
