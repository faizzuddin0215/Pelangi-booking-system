<?php

use App\Http\Controllers\CheckInReportController;
use App\Http\Controllers\CheckRateController;
use App\Http\Controllers\DailyGuestSumReportController;
use App\Http\Controllers\DriverReportController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LandOptionalController;
use App\Http\Controllers\NameListReportController;
use App\Http\Controllers\PaxReportController;
use App\Http\Controllers\PaymentSummaryReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RemarksController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoomDetailsController;
use App\Http\Controllers\RoomListReportController;
use App\Http\Controllers\SnorkellingReportController;
use App\Http\Controllers\SummaryPaymentController;
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

Route::get('/form2/{bookingId}/{amendId}', [RoomDetailsController::class, 'form2'])->name('form2');
Route::get('/form2/{bookingId}/{amendId}', [RoomDetailsController::class, 'booking']);
Route::post('/form2/{bookingId}/getRate', [RoomDetailsController::class, 'changeValue'])->name('change-value');
Route::post('/form2/{bookingId}/save', [RoomDetailsController::class, 'saveValue'])->name('save-value');
Route::post('/form2/{bookingId}/saveSpareRoom', [RoomDetailsController::class, 'saveSpareRoom'])->name('save-Spare-Room');

Route::get('/check_rate', [CheckRateController::class, 'check_rate'])->name('check_rate');
Route::post('/check_rate/getRate', [CheckRateController::class, 'changeValue'])->name('change-value');
Route::post('/check_rate/save', [CheckRateController::class, 'saveValue'])->name('save-value');
Route::post('/check_rate/saveSpareRoom', [CheckRateController::class, 'saveSpareRoom'])->name('save-Spare-Room');

Route::get('/form3/{bookingId}/{amendId}', [LandOptionalController::class, 'form3'])->name('form3');
Route::get('/form3/{bookingId}/{amendId}', [LandOptionalController::class, 'pickupDetails']);
Route::post('/form3/{bookingId}', [LandOptionalController::class, 'getPickupDetails'])->name('getPickupDetails');
Route::post('/form3/{bookingId}/save', [LandOptionalController::class, 'save'])->name('save');
Route::post('/form3/{bookingId}/other', [LandOptionalController::class, 'getPickupDetailsOther'])->name('getPickupDetailsOther');
Route::post('/form3/{bookingId}/otherDropoff', [LandOptionalController::class, 'getDropoffDetailsOther'])->name('getDropoffDetailsOther');
Route::post('/form3/{bookingId}/optionalOriginal', [LandOptionalController::class, 'optionalOriginal'])->name('optionalOriginal');
Route::post('/form3/{bookingId}/updateQtyOptional', [LandOptionalController::class, 'updateQtyOptional'])->name('updateQtyOptional');
Route::delete('/form3/{id}/delete-pickup', [LandOptionalController::class, 'deletePickup'])->name('bookings.deletePickup');
Route::delete('/form3/{bookingId}/deleteoptional', [LandOptionalController::class, 'deleteoptional'])->name('bookings.deleteoptional');

Route::get('/form4/{bookingId}/{amendId}', [RemarksController::class, 'form4'])->name('form4');
Route::get('/form4/{bookingId}/{amendId}', [RemarksController::class, 'bookingDetails']);
Route::post('/form4/{bookingId}', [RemarksController::class, 'updateField'])->name('update.field');
Route::post('/form4/{bookingId}/save', [RemarksController::class, 'save'])->name('save');

Route::get('/form5/{bookingId}/{amendId}', [SummaryPaymentController::class, 'form5'])->name('form5');
Route::get('/form5/{bookingId}/{amendId}', [SummaryPaymentController::class, 'totalDetails']);
Route::post('/form5/{bookingId}', [SummaryPaymentController::class, 'changeDeposit']); 
Route::post('/form5/{bookingId}/save', [SummaryPaymentController::class, 'savePayment']); 
Route::post('/form5/{bookingId}/addPayment', [SummaryPaymentController::class, 'addPayment']); 

Route::get('/invoice/{bookingId}/{amendId}', [InvoiceController::class, 'invoice'])->name('invoice');
Route::get('/invoice/{bookingId}/{amendId}', [InvoiceController::class, 'totalDetailsInvoice']);

Route::get('/check_in_out_report', [ReportController::class, 'index'])->name('check_in_out_report');
Route::get('/check_in_out_report', [ReportController::class, 'report'])->name('check_in_out_report');
Route::post('/check_in_out_report', [ReportController::class, 'filter'])->name('check_in_out_report.filter');

Route::get('/driver_report', [DriverReportController::class, 'index'])->name('driver_report');
Route::get('/driver_report', [DriverReportController::class, 'report'])->name('driver_report');
Route::post('/driver_report', [DriverReportController::class, 'filter'])->name('driver_report.filter');

Route::get('/room_list_report', [RoomListReportController::class, 'index'])->name('room_list_report');
Route::get('/room_list_report', [RoomListReportController::class, 'report'])->name('room_list_report');
Route::post('/room_list_report', [RoomListReportController::class, 'filter'])->name('room_list_report.filter');

Route::get('/name_list_report', [NameListReportController::class, 'index'])->name('name_list_report');
Route::get('/name_list_report', [NameListReportController::class, 'report'])->name('name_list_report');
Route::post('/name_list_report', [NameListReportController::class, 'filter'])->name('name_list_report.filter');

Route::get('/payment_summary_report', [PaymentSummaryReportController::class, 'index'])->name('payment_summary_report');
Route::get('/payment_summary_report', [PaymentSummaryReportController::class, 'report'])->name('payment_summary_report');
Route::post('/payment_summary_report', [PaymentSummaryReportController::class, 'filter'])->name('payment_summary_report.filter');

Route::get('/pax_report', [PaxReportController::class, 'index'])->name('pax_report');
Route::get('/pax_report', [PaxReportController::class, 'report'])->name('pax_report');
Route::post('/pax_report', [PaxReportController::class, 'filter'])->name('pax_report.filter');

Route::get('/daily_guest_sum_report', [DailyGuestSumReportController::class, 'index'])->name('daily_guest_sum_report');
Route::get('/daily_guest_sum_report', [DailyGuestSumReportController::class, 'report'])->name('daily_guest_sum_report');
Route::post('/daily_guest_sum_report', [DailyGuestSumReportController::class, 'filter'])->name('daily_guest_sum_report.filter');

Route::get('/snorkelling_report', [SnorkellingReportController::class, 'index'])->name('snorkelling_report');
Route::get('/snorkelling_report', [SnorkellingReportController::class, 'report'])->name('snorkelling_report');
Route::post('/snorkelling_report', [SnorkellingReportController::class, 'filter'])->name('snorkelling_report.filter');

Route::get('/check_in_report', [CheckInReportController::class, 'index'])->name('check_in_report');
Route::get('/check_in_report', [CheckInReportController::class, 'report'])->name('check_in_report');
Route::post('/check_in_report', [CheckInReportController::class, 'filter'])->name('check_in_report.filter');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
