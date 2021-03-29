<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Models\Workhours;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Settings extends Controller
{
    // Methode die de gebruikersinformatie ophaalt
    public function getUserinfo(Request $request)
    {
        // Gebruikersnaam ontsleutelen
        $username = Helper::decodeUsername($request->header('token'));

        // DB info ophalen
        $userinfo = Users::select('name', 'email', 'username', 'email_notification')
            ->where('username', $username)
            ->first();

        $workhours = Workhours::select('workhours')
            ->where('username', $username)
            ->first();

        return response()->json([
            'data' => $userinfo,
            'workhours' => $workhours,
        ]);
    }

    // Methode voor het opslaan van een nieuwe werkuren waarde
    public function setWorkhours(Request $request)
    {
        // Input valideren
        $validator = Validator::make($request->all(), [
           'workhours' => 'required'
        ], [
            'required' => 'Het aantal te werken uren is niet ingevuld.'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 406);
        }

        // Gebruikersnaam ontsleutelen
        $username = Helper::decodeUsername($request->header('token'));

        // Waarde in DB wijzigen
        Workhours::where('username', $username)
            ->update(['workhours' => $request->input('workhours')]);

        // Succesvol, response teruggeven
        return response()->json([
            'message' => 'Werkuren succesvol gewijzigd.',
            'username' => $username,
            'workhours' => $request->input('workhours')
        ]);
    }

    // Methode die de gebruikersinfo bijwerkt in de database
    public function setUserinfo(Request $request)
    {
        // Validatie uitvoeren
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'pass1' => 'min:6',
            'pass2' => 'same:pass1'
        ], [
            'required' => 'Het :attribute veld is niet ingevuld.',
            'email' => 'Onjuist e-mail adres opgegeven.',
            'min' => 'Het wachtwoord moet uit minimaal 6 karakters bestaan.',
            'same' => 'De twee ingevoerde wachtwoorden komen niet overeen.'
        ]);

        if ($validator->fails())
        {
            return response($validator->errors(), 406);
        }

        // Gebruikersnaam ontsleutelen
        $username = Helper::decodeUsername($request->header('token'));

        // Naam + e-mail opslaan
        Users::where('username', $username)
            ->update([
                'name' => $request->input('name'),
                'email' => $request->input('email')
            ]);

        // Wanneer wachtwoorden velden zijn ingevuld nieuw wachtwoord opslaan
        if ($request->filled(['pass1', 'pass2'])) {
            Users::where('username', $username)
                ->update([
                    'password' => Hash::make($request->input('pass1'))
                ]);
        }

        // Succes response teruggeven
        return response()->json([
           'message' => 'Gegevens succesvol opgeslagen.'
        ]);
    }

    // Methode die de boolean(s) wijzigt voor e-mail notificaties
    public function setEmailnotification(Request $request)
    {
        // Validatie uitvoeren
        $validation = Validator::make($request->all(), [
           'emailnotification' => 'required|boolean'
        ], [
            'required' => 'Geen data opgegeven.',
            'boolean' => 'Data onjuist aangeleverd!'
        ]);

        if ($validation->fails()) {
            return response($validation->errors(), 406);
        }

        // Gebruikersnaam ontsleutelen
        $username = Helper::decodeUsername($request->header('token'));

        // Nieuwe boolean waard(en) wegschrijven naar DB
        Users::where('username', $username)
            ->update(['email_notification' => $request->input('emailnotification')]);

        // Response teruggeven
        return response()->json([
            'message' => 'E-mail instellingen succesvol gewijzigd.'
        ]);
    }
}
