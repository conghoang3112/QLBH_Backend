<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\File;
use function storage_path;

class UserObserver
{
    /**
     * Handle the User "updating" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updating(User $user)
    {
        // if ($user->picture != $user->getOriginal('picture')) {
        //     File::delete(storage_path("/app/public/{$user->getOriginal('picture')}"));
        // }
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        // if ($user->picture) {
        //     File::delete(storage_path("/app/public/{$user->picture}"));
        // }
    }
}
