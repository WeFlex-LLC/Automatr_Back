<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use App\Notifications\UserPasswordReset;

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
        VerifyEmail::toMailUsing(function ($notifiable,$url){
            $mail = new MailMessage;
            $mail->subject('Automatr account activation');
            $mail->markdown('email.verify', ['url' => $url]);
            return $mail;
        });

        ResetPassword::toMailUsing(function (User $user,$token){
            $mail = new MailMessage;
            $mail->subject('Automatr reset password');
            $mail->markdown('password.reset', ['token' => $token, 'email' => $user->email]);
            return $mail;
        });
    }
    
}
