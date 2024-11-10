<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function getMyOrder(Request $request)
    {
        $request->validate([
            'no_resi' => 'required|string'
        ]);

        $noResi = $request['no_resi'];
        $package = Shipping::where('no_resi', $noResi)->firstOrFail();

        return response()->json([
            'message' => 'Success get related package',
            'package' => $package
        ]);
    }
}
