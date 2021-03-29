<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Workhours;
use Illuminate\Support\Facades\Validator;
use DateTime;

// Deze methodes zijn beschermd middels de Auth middleware (zonder username + geldige token geen toegang!)
class Registrations extends Controller
{
    // GET API - Methode die de registratie data terug geeft van een specifieke datum
    public function getReg(Request $request, $date)
    {
        // Gebruikersnaam ontsleutelen
        $username = Helper::decodeUsername($request->header('token'));

        // Data query uit DB halen via model
        $data = Registration::where('username', $username)
            ->where('date', $date)
            ->first();

        // Als er geen resultaat is
        if(is_null($data)) {
            return response()->json(false);
        }

        // Data terug geven
        return response()->json($data);
    }

    // GET - Geeft een registratie op basis van een ID
    public function getRegById($id)
    {
        // Registratie uit DB halen via model
        $data = Registration::where('id', $id)
            ->first();

        return response()->json($data);
    }

    // GET API - Methode die alle registraties data van een gebruiker geeft
    public function getRegs(Request $request)
    {
        // Gebruikersnaam ontsleutelen
        $username = Helper::decodeUsername($request->header('token'));

        // Data uit DB halen via model
        $data = Registration::where('username', $username)
            ->orderBy('date', 'desc')
            ->take(30)
            ->get();

        return response()->json($data);
    }

    // POST API - Methode die een registratie toevoegt in de database
    public function addReg(Request $request)
    {
        // Validatie input
        $this->validate($request, [
                'date' => 'required',
                'start' => 'required'
        ], [
                'required' => 'Het :attribute veld is niet ingevuld.'
        ]);

        // Gebruikersnaam ontsleutelen
        $username = Helper::decodeUsername($request->header('token'));

        // Controleren of er reeds een registratie bestaat
        $count_regs = Registration::where('username', $username)
            ->where('date', $request->input('date'))
            ->count();

        // Controleren of resultaat 0 is, anders foutmelding teruggeven
        if ($count_regs != 0) {
            $error = collect();
            $error->put(0, ['error' => 'Je hebt reeds een registratie op deze datum.']);
            return response()->json($error);
        }

        // Nieuwe gegevens invoeren in DB
        $registration = new Registration();
        $registration->username = $username;
        $registration->date = $request->input('date');
        $registration->start = $request->input('start');
        $registration->workedHours = '00:00';
        $registration->extraHours = '00:00';
        $registration->end = '00:00';
        $registration->calc = 1;

        $registration->save();

        // Succes teruggeven via response
        return response()->json([
            'status' => 'success'
        ]);
    }

    // POST API - Methode die de eindtijd en gewerkte uren berekend en in de database bijwerkt
    public function editReg(Request $request)
    {
        // Input valideren
        $validate = Validator::make($request->all(), [
            'date' => 'required',
            'end' => 'required'
        ]);

        if ($validate->fails()) {
            return response([
                'error' => 'Niet alle velden zijn ingevuld.'
            ], 406);
        }

        // Benodigde input ophalen uit request en db
        $date = $request->input('date');
        $end = $request->input('end');
        // Gebruikersnaam ontsleutelen
        $username = Helper::decodeUsername($request->header('token'));
        $start = Registration::where('username', $username)
            ->where('date', $date)
            ->value('start');

        // Gewerkte tijd berekenen
        $workedHours = Helper::calcWorkedHours($start, $end);

        // Het aantal te werken uren ophalen uit DB
        $workHours = Workhours::select('workhours')
            ->where('username', $username)
            ->first();

        // Extra- of te weinig gewerkte uren berekenen
        $extraHours = Helper::calcExtraHours($workedHours, $workHours['workhours']);

        // Waarden in DB bijwerken
        Registration::where('username', $username)
            ->where('date', $date)
            ->update(['end' => $request->input('end'),
                'workedHours' => $workedHours,
                'extraHours' => $extraHours]);

        // Nieuw saldo berekenen
        Helper::setSaldo($username);

        return response()->json([
            'status' => 'success',
            'workedHours' => $workedHours,
            'extraHours' => $extraHours
        ]);
    }

    // POST API - methode voor het verwerken van bulk registraties
    public function addBulkRegs(Request $request)
    {
        // Validatie - array moet data bevatten
        $this->validate($request, [
           'registration' => 'required|array',
            'registration.*.*' => 'required',
            'registration.*.date' => 'date'
        ], [
            'required' => 'Niet alle velden zijn ingevuld.',
            'date' => 'Een of meerdere datums zijn niet juist ingevuld.',
            'unique' => 'Er is reeds een registratie op een van de opgegeven datums.'
        ]);

        // Te werken uren per dag ophalen uit DB
        // Gebruikersnaam ontsleutelen
        $username = Helper::decodeUsername($request->header('token'));
        $workHours = Workhours::select('workhours')
            ->where('username', $username)
            ->first();

        // Array uitlezen
        foreach ($request->input('registration') as $reg)
        {
            // Gewerkte- en extra uren berekenen
            $workedHours = Helper::calcWorkedHours($reg['start'], $reg['end']);
            $extraHours = Helper::calcExtraHours($workedHours, $workHours->workhours);

            // Registratie toevoegen aan DB
            $registrations = new Registration();
            $registrations->username = $username;
            $registrations->date = $reg['date'];
            $registrations->start = $reg['start'];
            $registrations->end = $reg['end'];
            $registrations->workedHours = $workedHours;
            $registrations->extraHours = $extraHours;
            $registrations->calc = 1;
            $registrations->save();
        }

        // Nieuw saldo berekenen
        Helper::setSaldo($username);

        return response()->json([
           'status' => 'succes',
           'msg' => 'Alle registraties zijn succesvol verwerkt.'
        ]);
    }

    // Methode in API die de registratie bewerkt adhv het ID
    public function editRegById(Request $request, $id)
    {
        // ID is benodigd
        if (empty($id) || !filter_var($id, FILTER_VALIDATE_INT)) {
            return response()->json([
                'error' => 'Geen geldige ID'
            ]);
        }

        // Validatie op input uitvoeren
        $this->validate($request, [
            'date' => 'required|date',
            'start' => 'required',
            'end' => 'required',
            'calc' => 'required|boolean'
        ], [
            'required' => 'Het :attribute veld is niet ingevuld.',
            'date' => 'Geen geldige datum opgegeven.',
            'boolean' => 'Geen geldige waarde voor boolean opgegeven.',
            'integer' => 'Geen geldige ID opgegeven!'
        ]);

        // gebruikersnaam ophalen
        $username = Helper::decodeUsername($request->header('token'));

        // Gewerkte- en extra uren berekenen
        $workHours = Helper::getWorkhours($username);
        $workedHours = Helper::calcWorkedHours($request->input('start'), $request->input('end'));
        $extraHours = Helper::calcExtraHours($workedHours, $workHours);

        // Nieuwe waarden in DB bijwerken
        $reg = Registration::find($id);
        $reg->date = $request->input('date');
        $reg->start = $request->input('start');
        $reg->end = $request->input('end');
        $reg->workedHours = $workedHours;
        $reg->extraHours = $extraHours;
        $reg->calc = $request->input('calc');
        $reg->save();

        // nieuw saldo berekeken
        Helper::setSaldo($username);

        return response()->json([
           'message' => 'Gegevens zijn succesvol gewijzigd.'
        ]);
    }

    // Methode die een registratie verwijderd adhv het ID
    public function deleteRegById(Request $request, $id)
    {
        // id is benodigd in request
        $id = ['id' => $id];

        $validator = Validator::make($id, [
            'id' => 'required|integer'
        ], [
            'required' => 'ID is niet opgegeven!',
            'integer' => 'ID is geen valide getal'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        // Registratie verwijderen uit DB
        Registration::destroy($id);

        // Saldo herberekenen
        Helper::setSaldo(Helper::decodeUsername($request->header('token')));

        return response()->json([
           'message' => 'Registratie succesvol verwijderd.'
        ]);
    }

    // POST methode voor het opnemen van uren
    public function urenOpnemen(Request $request)
    {
        // Validatie
        $this->validate($request, [
           'datum' => 'required|date',
           'uren' => 'required',
        ], [
            'required' => 'Het :attribute veld is niet ingevuld.',
            'integer' => 'Ongeldige invoer voor aantal uren.'
        ]);

        // Gebruikersnaam ophalen
        $username = Helper::decodeUsername($request->header('token'));

        // Invoeren in database
        $Reg = new Registration;
        $Reg->username = $username;
        $Reg->date = $request->input('datum');
        $Reg->start = '00:00:00';
        $Reg->end = '00:00:01';
        $Reg->workedHours = '00:00:00';
        $Reg->extraHours = '-' . $request->input('uren');
        $Reg->calc = 1;
        $Reg->save();

        // nieuw saldo berekenen
        Helper::setSaldo($username);

        // Response teruggeven
        return response()->json(['message' => 'Uren zijn opgenomen van het saldo.']);
    }
}
