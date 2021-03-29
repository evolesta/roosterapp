<?php

namespace App\Http\Controllers;

use App\Models\Saldos;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Illuminate\Support\Facades\DB;

class Saldo extends Controller
{
    // Methode die de saldo informatie teruggeeft
    public function getSaldo(Request $request)
    {
        // Gebruikersnaam ontsleutelen
        $username = Helper::decodeUsername($request->header('token'));

        // Saldo uit DB ophalen
        $saldo = Saldos::where('username', $username)
            ->first();

        return response()->json([
            'username' => $username,
            'saldo' => $saldo['saldo']
        ]);
    }
}
