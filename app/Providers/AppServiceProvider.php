<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        Validator::extend('no_angle_brackets', function ($attribute, $value, $parameters, $validator) {
            return !str_contains($value, ['<', '>']);
        });

        
        DB::listen(function ($query) {
            // $query->sql
            // $query->bindings
            // $query->time
        });
        Validator::extend('emails', function ($attribute, $value, $parameters, $validator) {
        $emails = explode(",", $value);
        foreach ($emails as $k => $v) {
            if (isset($v) && $v !== "") {
                $temp_email = trim($v);
                if (!filter_var($temp_email, FILTER_VALIDATE_EMAIL)) {
                    return false;
                }
            }
        }
        return true;
        }, 'Error message - email is not in right format');

        User::observe(UserObserver::class);
    }
}
