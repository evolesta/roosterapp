<?php

namespace App\Providers;

use App\Models\Users;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Crypt;

class AuthServiceProvider extends ServiceProvider
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
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {

            // Token uit request halen
            $token = $request->header('token');

            if($token) {
                try {
                    JWT::decode($token, env('APP_KEY'), ['HS256']);
                    return new Users;
                } catch (ExpiredException $e) {
                    // token is niet meer geldig
                    return null;
                } catch (\Exception $e) {
                    // fout bij decoding token
                    return null;
                }
            }
        });
    }
}
