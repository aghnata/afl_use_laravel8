<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class TransportFeeController extends Controller
{
    public function index(){
        $data = DB::table('transport_fees')
        ->select('id', 'place_name', 'cost')->get();
        // dd($data);
        return view('contents.transport-fee.index', compact('data'));
        
    }
}
