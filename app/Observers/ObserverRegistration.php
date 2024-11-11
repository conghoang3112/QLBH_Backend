<?php
namespace App\Observers;

use App\Models\User;

class ObserverRegistration {
    public static function register(\Illuminate\Contracts\Foundation\Application $app){
        User::observe(UserObserver::class);
    }
}
