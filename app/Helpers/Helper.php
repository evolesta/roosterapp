<?php

namespace App\Helpers;

use App\Models\Registration;
use App\Models\Saldos;
use App\Models\Workhours;
use App\Models\Teams;
use DateTime;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;

class Helper
{
    // Gebruikersnaam ontsleutelen uit JWT token
    public static function decodeUsername(string $token)
    {
        // Token ontsleutelen middels key en algoritme
        $token = JWT::decode($token, env('APP_KEY'), ['HS256']);

        return $token->username;
    }

    // gebruikers ID ontsleutelen uit JWT token
    public static function decodeUserid(string $token)
    {
        $token = JWT::decode($token, env('APP_KEY'), ['HS256']);

        return $token->user_id;
    }

    // Werkuren ophalen voor een gebruiker
    public static function getWorkhours(string $username)
    {
        // DB bevragen
        $workhours = Workhours::select('workhours')
            ->where('username', $username)
            ->first();

        // Resultaat teruggeven
        return $workhours['workhours'];
    }

    // Methode die het aantal gewerkte uren berekent
    public static function calcWorkedHours($start, $end)
    {
        $start = new DateTime($start);
        $end = new DateTime($end);

        // Verschil tussen start en eind teruggeven in gewenst format
        $diff = $start->diff($end)
        ->format('%H:%i');

        return $diff;
    }

    // Methode die het extra- of te weinig gewerkte uren berekent
    public static function calcExtraHours($workedHours, $workHours)
    {
        $workHours = new DateTime($workHours);
        $workedHours = new DateTime($workedHours);

        // Verschil teruggeven in gewenst format
        return $workHours->diff($workedHours)
            ->format('%r%H:%i');
    }

    // Methode die het saldo opnieuw berekent en in DB bijwerkt
    public static function setSaldo($username)
    {
        // Nieuwe saldo berekenen
        $saldo = Registration::select(DB::raw('SEC_TO_TIME(SUM(TIME_TO_SEC(`extraHours`))) AS saldo'))
            ->where('username', $username)
            ->first();

        // Totaal gewerkte uren berekenen
        $workedHours = Registration::select(DB::raw('SEC_TO_TIME(SUM(TIME_TO_SEC(`workedHours`))) AS workedHours'))
            ->where('username', $username)
            ->first();

        // Nieuwe saldo in DB bijwerken
        Saldos::where('username', $username)
            ->update([
                'workedHours' => $workedHours['workedHours'],
                'saldo' => $saldo['saldo'],
            ]);
    }

    // Methode die de teams ophaalt voor een manager
    public static function getTeamsOfManager($id)
    {
        // Teams ophalen waar manager lid van is adhv zijn ID
        $teams = Teams::where('manager_Id', $id)
            ->select('id', 'name')
            ->get();
        // Als de manager geen leiding heeft over een team, dit dan toevoegen aan de lege array en al teruggeven
        if (count($teams) == 0) {
            $teams->put(0, ['name' => 'Je bent niet toegewezen als manager van (een) team(s)']);
            return $teams;
        }

        return $teams;
    }
}
