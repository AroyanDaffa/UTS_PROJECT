<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function getMyOrder(Request $request)
    {
        $request->validate([
            'no_resi' => 'required|string'
        ]);

        $noResi = $request['no_resi'];

        
    }
}
