<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Aflee;


class UserController extends Controller
{
    public function listAflee(){
        $data = DB::table('aflees')
        ->select('id', 'aflee_name', 'parent_wa_number')->get();
        // dd($data);
        return view('contents.user-management.list_aflee', compact('data'));
        
    }

    public function updateAflee(Request $request){
        
        if (auth()->user()->role_id == 1) {
            $aflee = Aflee::find($request->aflee_id);
            $aflee->parent_wa_number = $request->parent_wa_number;
            $aflee->save();
        } else {dd('access denied');}

        return redirect('/list-aflee');

    }
}
