<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VergetenUitklokken extends Mailable
{
    use Queueable, SerializesModels;

    public $naam;
    public $datum;
    public $start;

    public function __construct($naam, $datum, $start)
    {
        $this->naam = $naam;
        $this->datum = $datum;
        $this->start = $start;
    }

    public function build()
    {
        return $this->subject('RoosterApp - Nog lopende registraties')
        ->view('VergetenUitklokken');
    }
}
