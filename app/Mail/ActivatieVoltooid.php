<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class ActivatieVoltooid extends Mailable
{
    public $naam;

    public function __construct($naam)
    {
        $this->naam = $naam;
    }

    public function build()
    {
        return $this->subject('RoosterApp - Activatie voltooid!')
        ->view('ActivatieVoltooid');
    }
}
