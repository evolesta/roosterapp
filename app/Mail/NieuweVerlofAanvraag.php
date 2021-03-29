<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NieuweVerlofAanvraag extends Mailable
{
    use Queueable, SerializesModels;

    public $name_manager;
    public $name_user;
    public $reason;
    public $start;
    public $end;
    public $hours;

    public function __construct($name_manager, $name_user, $reason, $start, $end, $hours)
    {
        $this->name_manager = $name_manager;
        $this->name_user = $name_user;
        $this->reason = $reason;
        $this->start = $start;
        $this->end = $end;
        $this->hours = $hours;
    }

    public function build()
    {
        return $this->view('NieuweVerlofAanvraag')
            ->subject('RoosterApp - Nieuwe verlofaanvraag');
    }
}
