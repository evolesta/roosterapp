<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerlofAfgewezen extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $start;
    public $end;

    public function __construct($name, $start, $end)
    {
        $this->name = $name;
        $this->start = $start;
        $this->end = $end;
    }

    public function build()
    {
        return $this->subject('Verlof afgewezen')
            ->view('VerlofAfgewezen');
    }
}
