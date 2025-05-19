<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;

    /**
     * @param  \App\Models\Usuario  $user
     * @param  string               $token
     */
    public function __construct($user, string $token)
    {
        $this->user  = $user;
        $this->token = $token;
    }

    public function build()
    {
        $url = route('verification.verify', ['token' => $this->token]);

        return $this
            ->subject('Verifica tu cuenta en Indaluz')
            ->view('emails.verify')
            ->with([
                'name' => $this->user->nombre,
                'url'  => $url,
            ]);
    }
}
