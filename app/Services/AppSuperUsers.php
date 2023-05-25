<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class AppSuperUsers
{
    public function get(): Collection|array
    {
        $emails = preg_split("/[\s,|]+/", config('app.super_users'));
        $users = User::whereIn('email', $emails)->get();

        return $users->count() ? $users : $emails;

        // return [
        //     'emails' => $emails,
        //     'users' => User::whereIn('email', $emails)->get()
        // ];
    }
}
