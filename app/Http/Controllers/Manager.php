<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Mail\VerlofAfgewezen;
use App\Mail\VerlofGoedgekeurd;
use App\Models\Team_Members;
use App\Models\Teams;
use App\Models\Verloffen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class Manager extends Controller
{
    // GET methode om verschillende data voor een managers van team(s) op te halen
    public function getTeamsInsights(Request $request)
    {
        // User id ophalen uit JWT token
        $user_id = Helper::decodeUserid($request->header('token'));
        // Teams ophalen waar manager lid van is adhv zijn ID
        $teams = Helper::getTeamsOfManager($user_id);

        // Teamleden ophalen van team(s) en acties uitvoeren
        $team_members = collect();
        foreach ($teams as $team) {
            $team_members_team = Team_Members::where('team_members.Team_Id', $team->id)
                ->join('users', 'team_members.User_Id', '=', 'users.id')
                ->join('workhours', 'team_members.User_Id', '=', 'workhours.user_id')
                ->join('saldo', 'team_members.User_Id', '=', 'saldo.user_id')
                ->select('team_members.User_Id', 'team_members.Team_Id', 'users.name', 'workhours.workhours',
                    'saldo.workedHours', 'saldo.saldo')
                ->get();

            // Teamleden van elk team in variabele plaatsen
            foreach ($team_members_team as $team_member_team) {
                $team_members->put(null, [
                    'user_id' => $team_member_team->User_Id,
                    'team_id' => $team_member_team->Team_Id,
                    'team_name' => $team->name,
                    'name' => $team_member_team->name,
                    'workhours' => date('H.i', strtotime($team_member_team->workhours)),
                    'workedHours' => $team_member_team->workedHours,
                    'saldo' => $team_member_team->saldo
                ]);
            }
        }

        // Data teruggeven aan front-end
        return response()->json([
            'teams' => $teams,
            'team_members' => $team_members
        ]);
    }

    // GET methode voor het ophalen van bestaande verlofaanvragen
    public function getVerlofRequests(Request $request)
    {
        // Manager ID ophalen
        $manager_id = Helper::decodeUserid($request->header('token'));
        $teams = Helper::getTeamsOfManager($manager_id);

        // Lege array aanmaken
        $newVerlofRequests = array();

        // Teamleden ophalen voor ieder team
        foreach ($teams as $team) {
            $team_members = Team_Members::where('team_members.Team_Id', $team->id)
                ->join('verlof', function ($join) {
                    $join->on('team_members.User_Id', '=', 'verlof.user_id')
                        ->where('verlof.status', 'beoordeling');
                })
                ->join('users', 'team_members.User_Id', '=', 'users.id')
                ->orderBy('verlof.status', 'desc')
                ->select('verlof.id', 'verlof.reason', 'verlof.start', 'verlof.end', 'verlof.hours', 'verlof.status', 'users.name')
                ->get();

            // Voor elk lid uit het team informatie toevoegen aan collectie
            foreach ($team_members as $team_member) {
                $item = array(
                    'verlof_id' => $team_member->id,
                    'name' => $team_member->name,
                    'team' => $team->name,
                    'reason' => $team_member->reason,
                    'start' => $team_member->start,
                    'end' => $team_member->end,
                    'hours' => $team_member->hours,
                    'status' => $team_member->status
                );

                // nieuwe array item toevoegen aan bestaande array
                array_push($newVerlofRequests, $item);
            }
        }

        // Controleren of de array geen items bevat, zo ja een melding toevoegen.
        if (count($newVerlofRequests) == 0) {
            array_push($newVerlofRequests, array('name' => 'Er zijn geen openstaande aanvragen.'));
        }

        // collectie teruggeven
        return response()->json($newVerlofRequests);
    }

    // GET methode voor het ophalen van reeds behandelde verlofaanvragen
    public function getVerlof(Request $request)
    {
        // Manager ID ophalen
        $manager_id = Helper::decodeUserid($request->header('token'));
        $teams = Helper::getTeamsOfManager($manager_id);

        // Lege array aanmaken
        $verlofRequests = array();

        // Teamleden ophalen voor ieder team
        foreach ($teams as $team) {
            $team_members = Team_Members::where('team_members.Team_Id', $team->id)
                ->join('verlof', 'team_members.User_Id', '=', 'verlof.user_id')
                ->whereIn('verlof.status', ['akkoord', ['afgewezen']])
                ->join('users', 'team_members.User_Id', '=', 'users.id')
                ->select('users.name', 'verlof.reason', 'verlof.start', 'verlof.end', 'verlof.hours', 'verlof.status', 'verlof.id')
                ->get();

            // Voor elk teamlid met resultaat uit de verloftabel een item toevoegen aan de array
            foreach ($team_members as $team_member) {
                $item = array(
                    'name' => $team_member->name,
                    'reason' => $team_member->reason,
                    'start' => $team_member->start,
                    'end' => $team_member->end,
                    'hours' => $team_member->hours,
                    'status' => $team_member->status,
                    'verlof_id' => $team_member->id
                );

                // Nieuwe array item toevoegen
                array_push($verlofRequests, $item);
            }
        }

        // Controleren of de array leeg is
        if (count($verlofRequests) == 0) {
            // Item toevoegen dat er geen resultaten zijn
            array_push($verlofRequests, array('name' => 'Er zijn geen afgehandelde verzoeken.'));
        }

        // Resultaat teruggeven
        return response()->json($verlofRequests);
    }

    // PUT methode voor het accepteren van een verlofverzoek
    public function acceptVerlofRequest(Request $request, $id)
    {
        // DB bijwerken
        Verloffen::where('id', $id)
            ->update(['status' => 'akkoord']);

        // Informatie ophalen voor e-mail
        $user_info = Verloffen::where('verlof.id', $id)
            ->join('users', 'verlof.user_id', '=', 'users.id')
            ->select('verlof.user_id', 'verlof.start', 'verlof.end', 'users.name', 'users.email')
            ->first();

        // Gebruiker op de hoogte stellen
        Mail::to($user_info->email)->send(new VerlofGoedgekeurd($user_info->name, $user_info->start, $user_info->end));

        return response()->json(['message' => 'De verlofaanvraag is goedgekeurd.']);
    }

    // PUT methode voor het weigeren van een verlofverzoek
    public function denyVerlofRequest(Request $request, $id)
    {
        // DB bijwerken
        Verloffen::where('id', $id)
            ->update(['status' => 'afgewezen']);

        // Informatie ophalen voor e-mail
        $user_info = Verloffen::where('verlof.id', $id)
            ->join('users', 'verlof.user_id', '=', 'users.id')
            ->select('verlof.user_id', 'verlof.start', 'verlof.end', 'users.name', 'users.email')
            ->first();

        // Gebruiker op de hoogte stellen
        Mail::to($user_info->email)->send(new VerlofAfgewezen($user_info->name, $user_info->start, $user_info->end));

        return response()->json(['message' => 'De verlofaanvraag is afgewezen.']);
    }
}
