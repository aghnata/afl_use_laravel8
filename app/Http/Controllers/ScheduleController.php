<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Afler;
use App\Models\Aflee;
use App\Models\Grade;
use App\Models\TransportFee;
use Carbon\Carbon;
use DB;
use PDF;
use Storage;
use Illuminate\Http\Response;

class ScheduleController extends Controller
{
    //Show All Schedule
    public function all(){
        //get current user who login
        $user = auth()->user();
        $userRoleId = $user->role_id;
        $userAflerId = $user->afler_id;
        $userAfleeId = $user->aflee_id;
        $userName = $user->name;
        $startDate = null;
        $endDate = null;
        $aflerIdSort = null;
        $afleeIdSort = null;
        $sortedAflerName = null;
        $sortedAfleeName = null;

        // $startdatex = $date->endOfMonth();
        // $enddatex = $date->endOfMonth();
        // dd($userRoleId);
        if ($userRoleId == 1 || $userRoleId == 2) {
            // $schedules = Schedule::all();
            // $schedules = DB::table('schedules')->get();
            $dateStart = new Carbon('first day of this month');
            $dateEnd = Carbon::now()->endOfMonth();
            $schedules = Schedule::orderBy('date', 'asc')->whereBetween('date', [$dateStart->toDateString(), $dateEnd])->get();
            $isAdmin = true;
            $isAfler = true;
            $isAflee = true;
            $totalFee = $schedules->sum('total_fee');
            $totalCost = $schedules->sum('total_cost');
            $totalProfit = $schedules->sum('profit');
        }elseif($userRoleId == 4) {
            $schedules = Schedule::where('afler_id', $userAflerId)->where('fee_status', null)->get();
            $isAdmin = false;
            $isAfler = true;
            $isAflee = false;
            $totalFee = $schedules->sum('total_fee');
            $totalCost = null;
            $totalProfit = null;
        }elseif($userRoleId == 5){
            $schedules = Schedule::where('aflee_id', $userAfleeId)->where('cost_status', null)->get();
            $isAdmin = false;
            $isAfler = false;
            $isAflee = true;
            $totalCost = $schedules->sum('total_cost');
            $totalFee = null;
            $totalProfit = null;
        }
        
        $joinSG = Schedule::join('grades', 'schedules.grade_id', '=', 'grades.id')->get();
        
        $aflers = Afler::all();
        $aflees = Aflee::all();
        $grades = Grade::all();
        $locations = TransportFee::all();
        
        return view ('contents.schedule.Schedule', compact('schedules', 'totalFee', 'totalCost', 'joinSG', 'aflers', 'aflees', 'grades', 'locations', 
        'isAdmin', 'isAfler', 'isAflee', 'totalFee', 'totalProfit', 'userAflerId', 'userAfleeId', 'userName', 'startDate', 'endDate', 
        'aflerIdSort', 'afleeIdSort', 'sortedAflerName', 'sortedAfleeName' )); 
    }

    //Show Sorting Schedule
    public function sortingSchedule(Request $request){
        //dd($request->start_date, $request->end_date);
        //get current user who login
        // dd($request->all());
        $user = auth()->user();
        $userRoleId = $user->role_id;
        $userAflerId = $user->afler_id;
        $userAfleeId = $user->aflee_id;
        $userName = $user->name;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $aflerIdSort = $request->afler_id;
        $afleeIdSort = $request->aflee_id;
        $sortingType = $request->sorting_type;
        $paymentType = $request->payment_status;

        if ($sortingType == 'sorting_afler') { 
            $sortedAflerName = Afler::find($aflerIdSort)->afler_name;
            $sortedAfleeName = null;
        } elseif ($sortingType == 'sorting_aflee') {
            $sortedAfleeName = Aflee::find($afleeIdSort)->aflee_name;
            $sortedAflerName = null;
        } else {
            $sortedAfleeName = null;
            $sortedAflerName = null;
        }
               
        if ($userRoleId == 1 || $userRoleId == 2) {
            // pengurutan berdasarkan nama Afler tanpa filter tanggal
            if ($aflerIdSort != null && $startDate == null && $endDate == null && $afleeIdSort == null) {
                $schedules = Schedule::where('afler_id', $aflerIdSort)->get();
            
            // pengurutan berdasarkan nama Aflee tanpa filter tanggal
            } elseif ($afleeIdSort != null && $startDate == null && $endDate == null && $aflerIdSort == null) {
                $schedules = Schedule::where('aflee_id', $afleeIdSort)->get();
            
            // pengurutan berdasarkan aflee dan filter tanggal
            } elseif ($afleeIdSort != null && $startDate != null && $endDate != null && $aflerIdSort == null) {
                $schedules = Schedule::where('aflee_id', $afleeIdSort)->orderBy('date', 'asc')->whereBetween('date', [$startDate, $endDate])->get();

                //------------------------------ Kirim Tagihan ke Siswa ---------------------------------------------------------------
                if ($request->payment_status == "send_invoice") {

                    $dataAflee = Aflee::find($afleeIdSort);
                    $salam = $dataAflee->is_islam ? "Assalamu'alaikum Ibu/Bapak," : "Punten Ibu/Bapak,";
                    $parentWANo = $dataAflee->parent_wa_number;

                    if ($parentWANo) {
                        $finalStartDate = Carbon::parse($startDate)->format('d F Y');
                        $finalEndDate = Carbon::parse($endDate)->format('d F Y');
                        $totalCost = $schedules->sum('total_cost');
                        
                        $pdf = PDF::loadview('pdf.invoice', 
                        compact('schedules', 'sortedAfleeName', 'finalStartDate', 'finalEndDate', 'totalCost'))->setPaper('a4', 'landscape');
                        
                        $stdName = str_replace(" ", "", $sortedAfleeName);
                        $fileName = "invoice_".$startDate."to".$endDate."_".$stdName."_".$afleeIdSort.".pdf";
                        
                        try {
                            Storage::put('public/invoices/'.$fileName, $pdf->output());

                            foreach ($schedules as $sc) {
                                if ($sc->cost_status != 'transfered_by_Aflee') {
                                    $sc->cost_status = "billed";
                                    $sc->save();
                                } else {
                                    dd("cost sudah dibayar Aflee");
                                }
                            }
                        } catch (\Throwable $th) {
                            // file sudah ada jadi lngsung kirim invoice ke wa ortu
                            return view('send_to_wa.send_invoice', 
                            compact('fileName', 'salam', 'sortedAfleeName', 'finalStartDate', 'finalEndDate', 'totalCost', 'parentWANo'));
                        }
                        return view('send_to_wa.send_invoice', 
                        compact('fileName', 'salam', 'sortedAfleeName', 'finalStartDate', 'finalEndDate', 'totalCost', 'parentWANo'));    
                    } else {
                        dd('No Wa belum ada di db');
                    }
                }
                //------------------------------ END Kirim Tagihan ke Siswa -----------------------------------------------------------
            
            // pengurutan berdasarkan afler dan filter tanggal
            }elseif ($aflerIdSort != null && $startDate != null && $endDate != null && $afleeIdSort == null) {
                $schedules = Schedule::where('afler_id', $aflerIdSort)->orderBy('date', 'asc')->whereBetween('date', [$startDate, $endDate])->get();
            
                //------------------------------ Kirim Konfirmasi ke Pengajar ---------------------------------------------------------------
                if ($request->payment_status == "send_confirmation") {

                    $dataAfler = User::where('afler_id', $aflerIdSort)->first();
                    // $salam = $dataAfler->is_islam ? "Assalamu'alaikum Ibu/Bapak," : "Punten Ibu/Bapak,";
                    $wANo = $dataAfler->phone_number;

                    if ($wANo) {
                        $finalStartDate = Carbon::parse($startDate)->format('d F Y');
                        $finalEndDate = Carbon::parse($endDate)->format('d F Y');
                        $totalFee = $schedules->sum('total_fee');
                        
                        $pdf = PDF::loadview('pdf.confirmation', 
                        compact('schedules', 'sortedAflerName', 'finalStartDate', 'finalEndDate', 'totalFee'))->setPaper('a4', 'landscape');
                        
                        $teachName = str_replace(" ", "", $sortedAflerName);
                        $fileName = "confirmation_".$startDate."to".$endDate."_".$teachName."_".$aflerIdSort.".pdf";
                        
                        try {
                            Storage::put('public/confirmations/'.$fileName, $pdf->output());

                            // foreach ($schedules as $sc) {
                            //     if ($sc->cost_status != 'transfered_by_Aflee') {
                            //         $sc->cost_status = "billed";
                            //         $sc->save();
                            //     } else {
                            //         dd("cost sudah dibayar Aflee");
                            //     }
                            // }
                        } catch (\Throwable $th) {
                            // file sudah ada jadi lngsung kirim invoice ke wa ortu
                            return view('send_to_wa.send_confirmation', 
                            compact('fileName', 'sortedAflerName', 'finalStartDate', 'finalEndDate', 'totalFee', 'wANo'));
                        }
                        return view('send_to_wa.send_confirmation', 
                        compact('fileName', 'sortedAflerName', 'finalStartDate', 'finalEndDate', 'totalFee', 'wANo'));    
                    } else {
                        dd('No Wa belum ada di db');
                    }
                }
                //------------------------------ END Kirim Konfirmasi ke Pengajar -----------------------------------------------------------
            
            // pengurutan berdasarkan filter tanggal saja
            } elseif ($afleeIdSort == null && $startDate != null && $endDate != null && $aflerIdSort == null) {
                $schedules = Schedule::orderBy('date', 'asc')->whereBetween('date', [$startDate, $endDate])->get();
            
            } else {
                $schedules = Schedule::all();
            }
            $isAdmin = true;
            $isAfler = true;
            $isAflee = true;
            $totalFee = $schedules->sum('total_fee');
            $totalCost = $schedules->sum('total_cost');
            $totalProfit = $schedules->sum('profit');

        }elseif($userRoleId == 4) {
            if ($startDate == null && $endDate == null) {
                $schedules = Schedule::where('afler_id', $userAflerId)->get();        
            } else {
                $schedules = Schedule::where('afler_id', $userAflerId)->orderBy('date', 'asc')->whereBetween('date', [$startDate, $endDate])->get();
            }
            $isAdmin = false;
            $isAfler = true;
            $isAflee = false;
            $totalFee = $schedules->sum('total_fee');
        }elseif($userRoleId == 5){
            if ($startDate == null && $endDate == null) {
                $schedules = Schedule::where('aflee_id', $userAfleeId)->get();
            } else {
                $schedules = Schedule::where('aflee_id', $userAfleeId)->orderBy('date', 'asc')->whereBetween('date', [$startDate, $endDate])->get();
            }
            $isAdmin = false;
            $isAfler = false;
            $isAflee = true;
            $totalCost = $schedules->sum('total_cost');
        }
        //dd($paymentType, $schedules);
        if ($paymentType != false) {
            foreach ($schedules as $item) {
                $idSchedule = $item->id;
                $schedule = Schedule::find($idSchedule);
                if ($paymentType == 'payed_by_AFL') {
                    $schedule->fee_status = $paymentType;
                } elseif ($paymentType == 'transfered_by_Aflee') {
                    $schedule->cost_status = $paymentType;
                }
                $schedule->save();
            }
        }

        $joinSG = Schedule::join('grades', 'schedules.grade_id', '=', 'grades.id')->get();
        
        $aflers = Afler::all();
        $aflees = Aflee::all();
        $grades = Grade::all();
        $locations = TransportFee::all();
        
        return view ('contents.schedule.Schedule', compact('schedules', 'totalFee', 'totalCost', 'joinSG', 'aflers', 'aflees', 'grades', 'locations', 
        'isAdmin', 'isAfler', 'isAflee', 'totalCost', 'totalFee', 'totalProfit', 'userAflerId', 'userAfleeId', 'userName', 'startDate', 'endDate', 
        'aflerIdSort', 'afleeIdSort', 'sortedAflerName', 'sortedAfleeName' )); 
    }

    //Change fee_status and cost_statu in schedule
    public function changePaymentStatus(Request $request){
        //dd($request->afler_id);
        $user = auth()->user();
        $userRoleId = $user->role_id;
        $userAflerId = $user->afler_id;
        $userAfleeId = $user->aflee_id;
        $userName = $user->name;
        $aflerIdSort = $request->afler_id;
        $afleeIdSort = $request->aflee_id;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $paymentType = $request->payment_type;

        if ($userRoleId == 1) {
            // pengurutan berdasarkan nama Afler tanpa filter tanggal
            if ($aflerIdSort != null && $startDate == null && $endDate == null && $afleeIdSort == null) {
                $schedules = Schedule::where('afler_id', $aflerIdSort)->get();
                
            // pengurutan berdasarkan nama Aflee tanpa filter tanggal
            } elseif ($afleeIdSort != null && $startDate == null && $endDate == null && $aflerIdSort == null) {
                $schedules = Schedule::where('aflee_id', $afleeIdSort)->get();
            
            // pengurutan berdasarkan aflee dan filter tanggal
            } elseif ($afleeIdSort != null && $startDate != null && $endDate != null && $aflerIdSort == null) {
                $schedules = Schedule::where('aflee_id', $afleeIdSort)->orderBy('date', 'asc')->whereBetween('date', [$startDate, $endDate])->get();
            
            // pengurutan berdasarkan afler dan filter tanggal
            }elseif ($aflerIdSort != null && $startDate != null && $endDate != null && $afleeIdSort == null) {
                $schedules = Schedule::where('afler_id', $aflerIdSort)->orderBy('date', 'asc')->whereBetween('date', [$startDate, $endDate])->get();
            
            // pengurutan berdasarkan filter tanggal saja
            } elseif ($afleeIdSort == null && $startDate != null && $endDate != null && $aflerIdSort == null) {
                $schedules = Schedule::orderBy('date', 'asc')->whereBetween('date', [$startDate, $endDate])->get();
            
            } else {
                return redirect('/Schedule/SortingSchedule');
            }
            //dd($schedules);

            foreach ($schedules as $item) {
                $idSchedule = $item->id;
                $schedule = Schedule::find($idSchedule);
                if ($paymentType == 'payed_by_AFL') {
                    $schedule->fee_status = $paymentType;
                } elseif ($paymentType == 'transfered_by_Aflee') {
                    $schedule->cost_status = $paymentType;
                }
                $schedule->save();
            }
        }

        return redirect('/Schedule/All');
    }

    //Store Schedule
    public function store(Request $request){
        
        $session_fee = Grade::find($request->grade_id)->primary_fee;
        $session_cost = Grade::find($request->grade_id)->primary_cost;
        $ongkos = TransportFee::find($request->location_id)->cost;
        
        $schedule = new Schedule;
        $schedule->date = $request->date;
        $schedule->afler_id = $request->afler_id;
        if ($schedule->checkInput($request->afler_id)["checkGuru"] == 0) {
            return redirect('/Schedule/All')->with('warning', 'Dilarang input manual nama pengajar! Silakan pilih dari list yang ada di suggestion');
        }
        $schedule->aflee_id = $request->aflee_id;
        if ($schedule->checkInput($request->aflee_id)["checkSiswa"] == 0) {
            return redirect('/Schedule/All')->with('warning', 'Dilarang input manual nama siswa! Silakan pilih dari list yang ada di suggestion');
        }

        $schedule->grade_id = $request->grade_id;
        $schedule->transport_fee_id = $request->location_id;
        $schedule->sum_student = $request->sum_student;
        $schedule->fee_per_session = $schedule->salary($request->sum_student, $request->sum_session, $request->grade_id,$request->location_id)["fee_per_session"];
        $schedule->cost_per_session = $schedule->salary($request->sum_student, $request->sum_session, $request->grade_id,$request->location_id)["cost_per_session"];
        $schedule->sum_session = $request->sum_session;
        $schedule->total_fee = $schedule->salary($request->sum_student, $request->sum_session, $request->grade_id,$request->location_id)["total_fee"];
        $schedule->total_cost = $schedule->salary($request->sum_student, $request->sum_session, $request->grade_id,$request->location_id)["total_cost"];
        $schedule->profit = $schedule->total_cost - $schedule->total_fee;
        
        $userRoleId = auth()->user()->role_id;
        if ($userRoleId == 1) {
            $schedule->created_by = 'super_admin';
        } elseif ($userRoleId == 2) {
            $schedule->created_by = 'admin';            
        } elseif ($userRoleId == 4) {
            $schedule->created_by = 'afler';            
        } elseif ($userRoleId == 5) {
            $schedule->created_by = 'aflee';            
        }
        
        $schedule->save();

        return redirect('/Schedule/All');
    }

    //Delete Schedule
    public function delete(Request $request){
        $idSchedule = $request->idSchedule;
        $schedule = Schedule::find($idSchedule);
        $schedule->delete();
        return redirect ('Schedule/All'); 
    }

    public function downloadPDF($fileName){

        $forlderName = explode("_", $fileName, 2)[0] . 's/';
        
        if ($forlderName != 'confirmations/' && $forlderName != 'invoices/') {
            $forlderName = 'invoices/';
        }

        try {
            // $file = Storage::disk('public')->get('invoices/'.$fileName);
            $file = Storage::disk('public')->get($forlderName . $fileName);
            
            return (new Response($file, 200))
              ->header('Content-Type', 'application/pdf');

        } catch (\Throwable $th) {
            dd('File not found');
        }
  
    }
}
