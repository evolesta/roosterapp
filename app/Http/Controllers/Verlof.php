<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Mail\NieuweVerlofAanvraag;
use App\Models\Team_Members;
use App\Models\Users;
use App\Models\Verloffen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class Verlof extends Controller
{
    // GET methode voor het teruggeven van verlofdata
    public function getVerlof(Request $request)
    {
        // User id ophalen
        $user_id = Helper::decodeUserid($request->header('token'));
        // Gegevens uit DB verzamelen en teruggeven
        $data = Verloffen::where('user_id', $user_id)
            ->get();

        return response()->json(['data' => $data]);
    }

    // GET methode voor het teruggeven van specifieke verlofdata adhv id
    public function getVerlofById($id)
    {
        return response()->json(['data' => Verloffen::where('id', $id)->first()]);
    }

    // POST methode voor het toevoegen van een verlofaanvraag
    public function addVerlof(Request $request)
    {
        // Validatie van input
        $this->validate($request, [
           'reden' => 'required',
            'startdatum' => 'required|date',
            'einddatum' => 'required|date',
            'hours' => 'required|numeric'
        ], [
            'required' => 'Het veld is niet ingevuld.',
            'date' => 'Geen juiste datum opgegeven.',
            'numeric' => 'Onjuiste invoer, geen getal.'
        ]);

        $username = Helper::decodeUsername($request->header('token'));
        $userid = Helper::decodeUserid($request->header('token'));

        // Data invoeren in database
        $Verlof = new Verloffen;
        $Verlof->username = $username;
        $Verlof->user_id = $userid;
        $Verlof->reason = $request->input('reden');
        $Verlof->start = $request->input('startdatum');
        $Verlof->end = $request->input('einddatum');
        $Verlof->hours = $request->input('hours');
        $Verlof->status = 'concept';
        $Verlof->save();

        return response()->json(['message' => 'Verlofaanvraag succesvol opgeslagen.']);
    }

    // GET methode voor het indienen van verlof aan manager
    public function indienenVerlof(Request $request, $id)
    {
        // Database bijwerken
        Verloffen::where('id', $id)
            ->update(['status' => 'beoordeling']);

        $userid = Helper::decodeUserid($request->header('token'));
        $username = Helper::decodeUsername($request->header('token'));

        // Manager per e-mail op de hoogte stellen
        $manager_data = Team_Members::where('team_members.User_Id', $userid)
            ->join('team', 'team.id', '=', 'team_members.Team_Id')
            ->join('users', 'users.id', '=', 'team.manager_Id')
            ->select('team_members.Team_Id', 'team.manager_Id', 'users.name', 'users.email')
            ->first();

        $user_data = Users::where('username', $username)
            ->select('name')
            ->first();

        $verlof_data = Verloffen::where('id', $id)
            ->first();

        // Manager per e-mail op de hoogte stellen
        Mail::to($manager_data->email)->send(new NieuweVerlofAanvraag($manager_data->name, $user_data->name, $verlof_data->reason,
        $verlof_data->start, $verlof_data->end, $verlof_data->hours));

        return response()->json(['message' => 'Aanvraag succesvol ingediend. Deze wordt nu bij de manager aangeboden ter beoordeling.']);
    }

    // POST methode voor het bewerken van een bestaande aanvraag
    public function editVerlofById(Request $request, $id)
    {
        // Validatie van input
        $this->validate($request, [
            'reden' => 'required',
            'startdatum' => 'required|date',
            'einddatum' => 'required|date',
            'hours' => 'required|numeric'
        ], [
            'required' => 'Het veld is niet ingevuld.',
            'date' => 'Geen juiste datum opgegeven.',
            'numeric' => 'Onjuiste invoer, geen getal.'
        ]);

        // Nieuwe data bijwerken in DB
        $Verlof = Verloffen::find($id);
        $Verlof->reason = $request->input('reden');
        $Verlof->start = $request->input('startdatum');
        $Verlof->end = $request->input('einddatum');
        $Verlof->hours = $request->input('hours');
        $Verlof->save();

        return response()->json(['message' => 'Aanvraag succesvol gewijzigd.']);
    }

    // DELETE methode voor het verwijderen van een aanvraag
    public function deleteVerlof($id)
    {
        Verloffen::destroy($id);

        return response()->json(['message' => 'Aanvraag succesvol verwijderd.']);
    }
}
