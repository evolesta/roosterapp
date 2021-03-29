<?php

namespace App\Jobs;

use App\Mail\VergetenUitklokken;
use App\Models\Registration;
use Illuminate\Support\Facades\Mail;

class DailyRegCheck extends Job
{
    public function __construct()
    {

    }

    public function handle()
    {
        // Alle niet gestopte registraties ophalen uit de database
        $missedRegs = Registration::where('registrations.end', '00:00:00')
            ->join('users', 'registrations.username', '=', 'users.username')
            ->select('registrations.date', 'registrations.start', 'users.name', 'users.email', 'users.email_notification')
            ->get();

        // alleen uitvoeren als er meer dan 1 item in de resultaten array staat
        if (count($missedRegs) >= 1)
        {
            // Array van resultaten doorlopen
            foreach ($missedRegs as $missedReg) {
                // Stuur e-mail naar elke vergeten registratie, wanneer boolean van gebruiker true is
                if ($missedReg->email_notification = 1) {
                    Mail::to($missedReg->email)->send(new VergetenUitklokken($missedReg->name, $missedReg->date, $missedReg->start));
                }
            }
        }
    }
}
