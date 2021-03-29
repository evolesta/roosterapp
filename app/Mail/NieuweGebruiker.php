<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NieuweGebruiker extends Mailable
{
    public $naam;
    public $gebruikersnaam;
    public $id;

    public function __construct($naam, $gebruikersnaam, $id)
    {
        $this->naam = $naam;
        $this->gebruikersnaam = $gebruikersnaam;
        $this->id = $id;
    }

    public function build()
    {
        return $this->subject('RoosterApp - Nieuw account aangemaakt')
        ->view('NieuweGebruiker');
    }
}
