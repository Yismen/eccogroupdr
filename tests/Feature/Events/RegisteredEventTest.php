<?php

namespace Tests\Feature\Events;

use Tests\TestCase;
use App\Models\User;
use App\Services\AppSuperUsers;
use App\Listeners\NotifySuperAdmin;
use App\Mail\NotifySuperAdminEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisteredEventTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function app_listen_to_user_registered_event()
    {
        Event::fake([
            Registered::class
        ]);

        $user = User::factory()->create();
        Event::dispatch(new Registered($user));

        Event::assertListening(Registered::class, NotifySuperAdmin::class);
    }

    /** @test */
    public function app_notification_to_super_admin_when_a_new_user_register()
    {
        Mail::fake();
        $superUsersService = new AppSuperUsers();

        $user = User::factory()->create(['email' => 'yjorge@eccocorpbpo.com']);
        Event::dispatch(new Registered($user));

        Mail::assertSent(NotifySuperAdminEmail::class);
    }
}
