<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Sector;
use App\Models\Team_Members;
use App\Models\Teams;
use App\Models\Users;
use App\Models\Workhours;
use App\Models\Activations;
use App\Models\Saldos;
use App\Mail\NieuweGebruiker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class Admin extends Controller
{
    // GET methode die alle gebruikers teruggeeft
    public function getUsers(Request $request)
    {
        return response()->json([
           'data' => Users::select('username', 'name', 'active', 'id')
            ->get()]);
    }

    // GET methode om specifieke gebruiker informatie terug te geven
    public function getUserById($id)
    {
        return response()->json([
            'userdata' => Users::where('id', $id)->select('id', 'username', 'name', 'email', 'role', 'active')->first(),
            'assigned_team' => Team_Members::where('User_Id', $id)->select('Team_Id')->first(),
            'workhours' => Workhours::where('user_id', $id)->select('workhours')->first()
        ]);
    }

    // POST methode die een gebruiker toevoegt aan de applicatie
    public function addUser(Request $request)
    {
        // Validatie
        $this->validate($request, [
           'naam' => 'required|string',
            'gebruikersnaam' => 'required|string|max:6|unique:App\Models\Users,username',
            'team' => 'required|integer',
            'rol' => 'required',
            'werkuren' => 'required',
            'email' => 'required|email'
        ], [
            'required' => 'Het :attribute veld is niet ingevuld.',
            'string' => 'Onjuiste invoer.',
            'max' => 'Gebruikersnaam mag niet meer dan 6 tekens bevatten.',
            'email' => 'Ongeldig e-mailadres opgegeven.',
            'integer' => 'Invoer ongeldig.'
        ]);

        // variabelen aanmaken
        $naam = $request->input('naam');
        $gebruikersnaam = $request->input('gebruikersnaam');
        $email = $request->input('email');
        $id = Str::random(64);

        // gebruiker aanmaken in database
        $Users = new Users;
        $Users->username = $gebruikersnaam;
        $Users->name = $naam;
        $Users->email = $email;
        $Users->role = $request->input('rol');
        $Users->password = Hash::make(Str::random(32));
        $Users->email_notification = 1;
        $Users->active = 0;
        $Users->save();

        // Gebruiker ID ophalen
        $user_id = Users::where('username', $gebruikersnaam)
            ->select('id')
            ->first();

        // Werkuren tabel invoegen
        $Workhours = new Workhours;
        $Workhours->username = $gebruikersnaam;
        $Workhours->user_id = $user_id->id;
        $Workhours->workhours = $request->input('werkuren');
        $Workhours->save();

        // Saldo tabel invoegen
        $Saldos = new Saldos;
        $Saldos->username = $gebruikersnaam;
        $Saldos->user_id = $user_id->id;
        $Saldos->saldo = '00:00:00';
        $Saldos->workedHours = '00:00:00';
        $Saldos->save();

        $Teammembers = new Team_Members;
        $Teammembers->User_Id = $user_id->id;
        $Teammembers->Team_Id = $request->input('team');
        $Teammembers->save();

        // Activatie aanmaken
        $Activations = new Activations;
        $Activations->username = $gebruikersnaam;
        $Activations->activation_id = $id;
        $Activations->activated = 0;
        $Activations->save();

        // Welkom mail sturen naar gebruiker via Mailable
        Mail::to($email)->send(new NieuweGebruiker($naam, $gebruikersnaam, $id));

        return response()->json([
            'message' => 'Gebruiker succesvol aangemaakt en e-mail is verzonden.'
        ]);
    }

    // POST methode om een bestaande gebruiker te bewerken
    public function editUser(Request $request, $id)
    {
        // Validatie
        $this->validate($request, [
            'naam' => 'required|string',
            'team' => 'required|integer',
            'rol' => 'required',
            'werkuren' => 'required',
            'email' => 'required|email'
        ], [
            'required' => 'Het :attribute veld is niet ingevuld.',
            'string' => 'Onjuiste invoer.',
            'max' => 'Gebruikersnaam mag niet meer dan 6 tekens bevatten.',
            'email' => 'Ongeldig e-mailadres opgegeven.',
            'integer' => 'Invoer ongeldig.'
        ]);

        // Data wijzigen in database
        $Users = Users::find($id);
        $Users->name = $request->input('naam');
        $Users->email = $request->input('email');
        $Users->role = $request->input('rol');
        $Users->save();

        Workhours::where('user_id', $id)
            ->update([
                'workhours' => $request->input('werkuren')
            ]);

        Team_Members::where('User_Id', $id)
            ->update(['Team_Id' => $request->input('team')]);

        return response()->json(['message' => 'Gebruiker succesvol gewijzigd.']);
    }

    // GET methode die alle teams + managers teruggeeft
    public function getTeams(Request $request)
    {
        return response()->json([
           'teams' => Teams::all(),
            'managers' => Users::where('role', 'manager')->get(),
            'sectors' => Sector::all()
        ]);
    }

    // GET methode die specifieke team informatie teruggeeft adhv id
    public function getTeamById($id)
    {
        $data = Teams::where('team.id', $id)
            ->join('users', 'team.manager_Id', '=', 'users.id')
            ->join('sector', 'team.sector_Id', '=', 'sector.id')
            ->select('team.name', 'team.id', 'users.name as manager_name', 'users.id as manager_id', 'sector.name as sector_name', 'sector.id as sector_id')
            ->first();

        return response()->json(['data' => $data]);
    }

    // GET methode die de teamleden ophaalt uit de members tabel
    public function getTeamMembers($id)
    {
        $data = Team_Members::where('team_members.Team_Id', $id)
            ->join('users', 'team_members.User_Id', '=', 'users.id')
            ->join('team', 'team_members.Team_Id', '=', 'team.id')
            ->select('Team_Id', 'User_Id', 'users.name as user_name', 'team.name as team_name')
            ->get();

        return response()->json($data);
    }

    // POST methode om een nieuw team toe te voegen
    public function addTeam(Request $request)
    {
        // Validatie van input
        $this->validate($request, [
            'teamnaam' => 'required|string',
            'manager_id' => 'required|integer',
            'sector_id' => 'required|integer'
        ], [
            'required' => 'Het :attribute veld is niet ingevuld.',
            'string' => 'Ongeldige invoer.',
            'integer' => 'Ongeldige invoer.'
        ]);

        // Team in DB invoeren
        $Teams = new Teams;
        $Teams->name = $request->input('teamnaam');
        $Teams->manager_Id = $request->input('manager_id');
        $Teams->sector_Id = $request->input('sector_id');
        $Teams->save();

        return response()->json(['message' => 'Nieuw team succesvol aangemaakt.']);
    }

    // POST methode voor het wijzigen van een team
    public function editTeam(Request $request, $id)
    {
        // Validatie uitvoeren op input
        $this->validate($request, [
           'teamnaam' => 'required|string',
           'manager_id' => 'required|integer',
           'sector_id' => 'required|integer'
        ], [
            'required' => 'Het :attribute veld is niet ingevuld.',
            'string' => 'Onjuiste invoer.',
            'integer' => 'Onjuiste invoer.'
        ]);

        // Data wijzigen in DB
        $Teams = Teams::find($id);
        $Teams->name = $request->input('teamnaam');
        $Teams->manager_Id = $request->input('manager_id');
        $Teams->sector_Id = $request->input('sector_id');
        $Teams->save();

        return response()->json(['message' => 'Gegevens succesvol gewijzigd.']);
    }

    // DELETE methode om team te verwijderen
    public function deleteTeam($id)
    {
        // Rij verwijderen uit teams tabel
        Teams::destroy($id);

        return response()->json(['message' => 'Team succesvol verwijderd.']);
    }

    // GET methode die alle sector data teruggeeft
    public function getSector(Request $request)
    {
        // Data ophalen uit DB en teruggeven
        return response()->json([
            'data' => Sector::all()]);
    }

    // Methode die de informatie van een sector ophaalt adhv id
    public function getSectorById(Request $request, $id)
    {
        if (empty($id)) {
           return response('Geen ID opgegeven', 406);
        }

        // Data ophalen uit DB en teruggeven
        return response()->json([
           'data' => Sector::where('id', $id)
           ->first()]);
    }

    // Methode die een nieuwe sector toevoegt aan de database
    public function addSector(Request $request)
    {
        // Input valideren
        $this->validate($request, [
            'name' => 'required|string'
        ], [
            'required' => 'Het :attribute veld is niet ingevuld.',
            'string' => 'Geen geldige naam opgegeven.'
        ]);

        // Sector toevoegen in DB
        $sector = new Sector;
        $sector->name = $request->input('name');
        $sector->save();

        return response()->json([
            'message' => 'Nieuwe sector succesvol toegevoegd.'
        ]);
    }

    // Methode die een sector wijzigt in de database
    public function editSector(Request $request, $id)
    {
        // Input valideren
        $this->validate($request, [
            'name' => 'required|string'
        ], [
            'required' => 'Het :attribute veld is niet ingevuld.',
            'string' => 'Geen geldige naam opgegeven.'
        ]);

        // Sector aanpassen in DB
        $sector = Sector::find($id);
        $sector->name = $request->input('name');
        $sector->save();

        return response()->json([
            'message' => 'Sector naam succesvol gewijzigd.'
        ]);
    }

    // Methode die een sector verwijderd uit de database
    public function deleteSector(Request $request, $id)
    {
        // Sector verwijderen uit database
        Sector::destroy($id);

        return response()->json([
            'message' => 'Sector succesvol verwijderd.'
        ]);
    }
}
