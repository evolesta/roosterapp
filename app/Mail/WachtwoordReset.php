<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

class WachtwoordReset extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $id;

    public function __construct($name, $id)
    {
        $this->name = $name;
        $this->id = $id;
    }

    public function build()
    {
        return $this->subject('RoosterApp - Wachtwoord Reset')
        ->view('WachtwoordReset');
    }
}
