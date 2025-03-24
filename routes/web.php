<?php

use App\Http\Controllers\CheckInReportController;
use App\Http\Controllers\DriverReportController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoomListReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/form', [FormController::class, 'index'])->name('form');
Route::post('/form', [FormController::class, 'submit'])->name('form.submit');
Route::get('/form', [FormController::class, 'leads'])->name('form');
Route::get('/form/{booking_id}/getBookingData/{amend_id}', [FormController::class, 'getBookingData']);
Route::get('/form/{booking_id}/getBookingAmendData', [FormController::class, 'getBookingAmendData']);
Route::post('/form/{booking_id}', [FormController::class, 'amendBooking']);

Route::get('/form2/{bookingId}/{amendId}', [FormController::class, 'form2'])->name('form2');
Route::get('/form2/{bookingId}/{amendId}', [FormController::class, 'booking']);
Route::post('/form2/{bookingId}/getRate', [FormController::class, 'changeValue'])->name('change-value');
Route::post('/form2/{bookingId}/save', [FormController::class, 'saveValue'])->name('save-value');

Route::get('/form3/{bookingId}/{amendId}', [FormController::class, 'form3'])->name('form3');
Route::get('/form3/{bookingId}/{amendId}', [FormController::class, 'pickupDetails']);
Route::post('/form3/{bookingId}', [FormController::class, 'getPickupDetails'])->name('getPickupDetails');
Route::post('/form3/{bookingId}/optionalOriginal', [FormController::class, 'optionalOriginal'])->name('optionalOriginal');
Route::post('/form3/{bookingId}/updateQtyOptional', [FormController::class, 'updateQtyOptional'])->name('updateQtyOptional');
Route::delete('/form3/{id}/delete-pickup', [FormController::class, 'deletePickup'])->name('bookings.deletePickup');
Route::delete('/form3/{bookingId}/deleteoptional', [FormController::class, 'deleteoptional'])->name('bookings.deleteoptional');

Route::get('/form4/{bookingId}/{amendId}', [FormController::class, 'form4'])->name('form4');
Route::get('/form4/{bookingId}/{amendId}', [FormController::class, 'bookingDetails']);
Route::post('/form4/{bookingId}', [FormController::class, 'updateField'])->name('update.field');

Route::get('/form5/{bookingId}/{amendId}', [FormController::class, 'form5'])->name('form5');
Route::get('/form5/{bookingId}/{amendId}', [FormController::class, 'totalDetails']);
Route::post('/form5/{bookingId}', [FormController::class, 'changeDeposit']); 
Route::post('/form5/{bookingId}/save', [FormController::class, 'savePayment']); 
Route::post('/form5/{bookingId}/addPayment', [FormController::class, 'addPayment']); 

Route::get('/check_in_out_report', [ReportController::class, 'index'])->name('check_in_out_report');
Route::get('/check_in_out_report', [ReportController::class, 'report'])->name('check_in_out_report');
Route::post('/check_in_out_report', [ReportController::class, 'filter'])->name('check_in_out_report.filter');

Route::get('/driver_report', [DriverReportController::class, 'index'])->name('driver_report');
Route::get('/driver_report', [DriverReportController::class, 'report'])->name('driver_report');
Route::post('/driver_report', [DriverReportController::class, 'filter'])->name('driver_report.filter');

Route::get('/room_list_report', [RoomListReportController::class, 'index'])->name('room_list_report');
Route::get('/room_list_report', [RoomListReportController::class, 'report'])->name('room_list_report');
Route::post('/room_list_report', [RoomListReportController::class, 'filter'])->name('room_list_report.filter');

Route::get('/check_in_report', [CheckInReportController::class, 'index'])->name('check_in_report');
Route::get('/check_in_report', [CheckInReportController::class, 'report'])->name('check_in_report');
Route::post('/check_in_report', [CheckInReportController::class, 'filter'])->name('check_in_report.filter');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
