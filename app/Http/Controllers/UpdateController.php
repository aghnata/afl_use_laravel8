<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransportFee;

class UpdateController extends Controller
{
    public function updateTransportFee(){

        if (auth()->user()->role_id == 1) {
            # code...
            $fees = TransportFee::all();
   
            // dd("berhasil masuk");
            foreach ($fees as $item) {
                $fee = TransportFee::find($item->id);
                $fee->cost_old_1 = $fee->cost;
                $fee->cost = $fee->cost + 6000;
                $fee->save();
            }
    
            dd("Data updated");
        } else {
            dd("Anda tidak punya akses ke halaman ini");
        }
    }
}
