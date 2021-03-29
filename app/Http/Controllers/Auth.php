<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Mail\WachtwoordReset;
use App\Models\Password_Resets;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Activations;
use App\Mail\ActivatieVoltooid;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Mockery\Generator\StringManipulation\Pass\Pass;

class Auth extends Controller
{
    // JWT token genereren
    public function generateToken($user, $id, $role, $expiration)
    {
        $payload = [
            'iss' => "lumen-jwt",
            'username' => $user,
            'user_id' => $id,
            'role' => $role,
            'iat' => time(),
            'exp' => time() + $expiration
        ];

        // Gegenereerde token teruggeven
        return JWT::encode($payload, env('APP_KEY'), 'HS256');
    }

    // Gebruiker authenticeren voor applicatie
    public function login(Request $request)
    {
        // Input valideren
        $rules = [
            'username' => 'required|max:6',
            'password' => 'required'
        ];

        // Als de validatie mislukt, geven we een error terug
        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return response([
                'error' => 'Niet alle velden zijn ingevuld.'
            ], 401);
        }

        // Input van request in vars stoppen
        $username = $request->input('username');
        $password = $request->input('password');

        // Gebruikersgegevens ophalen van DB
        // Als er geen resultaat is, klopt de gebruikersnaam niet. Dan geven met de firstOr methode een foutmelding terug
        $dbuser = Users::where('username', $username)
            ->firstOr(['password', 'role', 'id', 'active'], function () {
                return response([
                    'error' => 'Gebruikersnaam of wachtwoord onjuist.'
                ], 401);
            });

        // Wachtwoord controleren of deze overeenkomt in de DB
        // Wachtwoord in DB is een hash, m.b.v. de Hash class (check methode) controleren we of de input juist is
        if(Hash::check($password, $dbuser['password']))
        {
            // controleren of gebruiker actief is
            if($dbuser->active != 1)
            {
                return response(['error' => 'Je account is geblokkeerd. Neem contact op met een beheerder.'], 406);
            }

            // controleren of "blijf ingelogd" is aangevinkt
            if ($request->input('stayloggedin') == true) {
                // verloopdatum 1 dag
                $expiration = 60*60*24;
            } else {
                // verloopdatum 1 uur
                $expiration = 60*60;
            }

            // Username + wachtwoord zijn correct
            // Succes response geven met token en versleutelde gebruikersnaam
            // Gebruikersnaam wordt versleuteld middels de Crypt klasse
            return response()->json([
                'token' => $this->generateToken($username, $dbuser->id, $dbuser['role'], $expiration)
            ]);
        } else {
            // Misluke inlogpoging, error response geven
            return response([
                'error' => 'Gebruikersnaam of wachtwoord onjuist.'
            ], 401);
        }
    }

    // Methode die teruggeeft welke rol de gebruiker heeft
    public function getRole(Request $request) {
        // Gebruikersnaam ontsleutelen uit request
        $username = Helper::decodeUsername($request->header('token'));

        // Database bevragen
        $data = Users::select('role')
            ->where('username', $username)
            ->value('role');

        return response()->json([
            'role' => $data
        ]);
    }

    // Methode die controleert of de token juist is
    public function isAuthenticated()
    {
        // omdat authenticatie al reeds plaatsvindt in de middleware kunnen we altijd true teruggeven
        return response()->json(true);
    }

    // POST methode die de gebruiker activeert
    public function activateUser(Request $request, $id)
    {
        // Validatie
        $this->validate($request, [
           'wachtwoord' => 'required|string',
           'wachtwoord2' => 'required|string|same:wachtwoord'
        ], [
            'required' => 'Het :attribute veld is niet ingevuld.',
            'string' => 'Onjuiste invoer.',
            'same' => 'De twee wachtwoord velden komen niet overeen.'
        ]);

        // Controleren of ID klopt met ID uit DB
        $countID = Activations::where('activation_id', $id)
            ->count();

        if ($countID != 1) {
            return response(['error' => 'Opgegeven ID bestaat niet!'], 406);
        }

        // gebruikersinformatie ophalen uit DB via JOIN
        $userinfo = Activations::where('activation_id', $id)
            ->join('users', 'activation.username', '=', 'users.username')
            ->select('activation.username', 'activation.activated', 'users.name', 'users.email')
            ->first();

        // controleren of gebruiker al geactiveerd is
        if ($userinfo->activated != 0) {
            return response(['error' => 'Gebruiker is al reeds geactiveerd.'], 406);
        }

        // Tabellen bijwerken, gebruiker activeren en wachtwoord wijzigen
        Activations::where('username', $userinfo->username)
            ->update([
                'activated' => 1
            ]);

        Users::where('username', $userinfo->username)
            ->update([
                'password' => Hash::make($request->input('wachtwoord')),
                'active' => 1
            ]);

        // Gebruiker mailen dat het account geactiveerd is
        Mail::to($userinfo->email)->send(new ActivatieVoltooid($userinfo->name));

        return response()->json(['message' => 'Gebruiker is succesvol geactiveerd.']);
    }

    // POST methode voor het resetten van een wachtwoord
    // ontvangt het verzoek en stuurt een mailtje
    public function resetPassword(Request $request)
    {
        // Validatie
        $this->validate($request, [
            'gebruikersnaam' => 'required|string|max:6',
            'emailadres' => 'required|email'
        ], [
            'required' => 'Het :attribute veld is niet ingevuld.',
            'string'=> 'Onjuiste invoer.',
            'email' => 'Geen geldig e-mail adres opgegeven.',
            'max' => 'Onjuite grootte gebruikersnaam opgegeven.'
        ]);

        // controleren of gebruikersnaam en emailadres te vinden zijn in database in dezelfde rij
        $countInDB = Users::where('username', $request->input('gebruikersnaam'))
            ->where('email', $request->input('emailadres'))
            ->count();

        if ($countInDB != 1) {
            return response(['error' => 'De opgegeven combinatie gebruikersnaam of e-mailadres zijn niet bekend.'], 406);
        }

        // Uniek ID geneneren
        $id = Str::random(64);

        // Verloop timestamp genereren (15 min in de toekomst)
        $timestamp = date('Y-m-d H:i:s', strtotime(date('H:i')) + 60*15);

        // password_reset tabel invoeren
        $Reset = new Password_Resets;
        $Reset->username = $request->input('gebruikersnaam');
        $Reset->reset_id = $id;
        $Reset->expiration = $timestamp;
        $Reset->password_set = 0;
        $Reset->save();

        // Gebruiker een email sturen met reset link
        $User = Users::where('username', $request->input('gebruikersnaam'))
            ->select('email', 'name')
            ->first();

        Mail::to($User->email)->send(new WachtwoordReset($User->name, $id));

        return response()->json(['message' => 'Er is een link naar je e-mail adres verstuurd om een nieuw wachtwoord in te stellen.']);
    }

    // POST methode om het nieuwe wachtwoord in te stellen voor de gebruiker
    public function setPassword(Request $request, $id)
    {
        // Validatie
        $this->validate($request, [
           'wachtwoord1' => 'required',
           'wachtwoord2' => 'required|same:wachtwoord1'
        ], [
            'required' => 'Het :attribute veld is niet ingevuld.',
            'same' => 'De twee wachtwoorden komen niet overeen.'
        ]);

        // Controleren of ID bestaat in DB
        $dbcountID = Password_Resets::where('reset_id', $id)
            ->count();

        if ($dbcountID != 1) {
            return response(['error' => 'Opgegeven ID bestaat niet in DB!']);
        }

        // Verloopdatum controleren
        // Verloopdatum ophalen uit DB
        $dbinfo = Password_Resets::where('reset_id', $id)
            ->select('expiration', 'username', 'password_set')
            ->first();
        $dbtimestamp = strtotime($dbinfo->expiration);

        // Huidige timestamp ophalen
        $timestamp = strtotime(date('H:i'));

        if ($dbtimestamp <= $timestamp) {
            return response(['error' => 'De opgegeven link is niet meer geldig. Probeer het opnieuw.'], 406);
        }

        // Controleren of wachtwoord al reeds is gewijzigd
        if ($dbinfo->password_set != 0) {
            return response(['error' => 'Het wachtwoord is al gewijzigd.'], 406);
        }

        // ID en verloopdatum zijn oke, dus kunnen we het wachtwoord wijzigen
        Users::where('username', $dbinfo->username)
            ->update(['password' => Hash::make($request->input('wachtwoord1'))]);

        // Reset tabel bijwerken
        Password_Resets::where('reset_id', $id)
            ->update(['password_set' => 1]);

        return response()->json(['message' => 'Wachtwoord is succesvol gewijzigd. Log nu in met je nieuwe wachtwoord!']);
    }
}
