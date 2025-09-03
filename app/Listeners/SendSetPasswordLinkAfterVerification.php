<?php

// app/Listeners/SendSetPasswordLinkAfterVerification.php
namespace App\Listeners;

use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Password;

class SendSetPasswordLinkAfterVerification
{
    public function handle(Verified $event): void
    {
        $user = $event->user;

        // Kirimkan email reset password (jadi user set password sendiri)
        Password::sendResetLink(['email' => $user->email]);
    }
}
