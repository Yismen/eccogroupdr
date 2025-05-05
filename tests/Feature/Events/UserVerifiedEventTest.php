<?php

namespace Tests\Feature\Events;

use Tests\TestCase;
use App\Models\User;
use App\Services\AppSuperUsers;
use App\Listeners\NotifySuperAdmin;
use App\Mail\NotifySuperAdminEmail;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserVerifiedEventTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function send_email_when_user_verify_account()
    {
        Event::fake([
            Verified::class
        ]);

        $user = User::factory()->create();
        Event::dispatch(new Verified($user));

        Event::assertListening(Verified::class, NotifySuperAdmin::class);
    }

    /** @test */
    public function app_notification_to_super_admin_when_an_user_verifies_account()
    {
        Mail::fake();
        $superUsersService = new AppSuperUsers();

        $user = User::factory()->create(['email' => 'yjorge@eccocorpbpo.com']);
        Event::dispatch(new Verified($user));

        Mail::assertSent(NotifySuperAdminEmail::class);
    }
}
