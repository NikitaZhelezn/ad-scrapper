<?php

namespace App\Services;

use App\Models\AdPage;
use App\Models\User;

class UserService
{
    /**
     * @param string $email
     * @return User
     */
    public function getUser(string $email): User
    {
        if (! $user = User::where('email', $email)->first()) {
            return User::create([
                'email' => $email
            ]);
        }

        return $user;
    }

    /**
     * @param User $user
     * @param AdPage $page
     * @return void
     */
    public function attachPage(User $user, AdPage $page): void
    {
        if ($user->pages()->where('page_id', $page->id)->exists()) {
            return;
        }

        $user->pages()->attach($page);
    }
}
