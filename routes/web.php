<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UpdateController;
use App\Http\Controllers\TransportFeeController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/Schedule/download_pdf/{fileName}', [ScheduleController::class, 'downloadPDF']);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/Schedule/All', [ScheduleController::class, 'all']);
    Route::post('/Schedule/SortingSchedule', [ScheduleController::class, 'sortingSchedule']);
    Route::post('/Schedule/ChangePaymentStatus', [ScheduleController::class, 'changePaymentStatus']);
    Route::post('/Schedule/Store', [ScheduleController::class, 'store']);
    Route::post('/Schedule/Delete', [ScheduleController::class, 'delete']);
    
    //update transport fee
    Route::get('/Update/TransportFee', [UpdateController::class, 'updateTransportFee']);

    //List Transport Fee
    Route::get('/transport-fee', [TransportFeeController::class, 'index']);
    
    //List Aflee
    Route::get('/list-aflee', [UserController::class, 'listAflee']);
    Route::put('/update-aflee',[UserController::class, 'updateAflee']);

    

});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
