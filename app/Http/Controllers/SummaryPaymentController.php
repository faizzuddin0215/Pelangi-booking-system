<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\DropoffDetails;
use App\Models\PickupDetails;
use App\Models\receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SummaryPaymentController extends Controller
{
    public function form5($bookingId, $amendId) {
        // Use the bookingId for logic or pass it to the view
        return view('form5', compact('bookingId', 'amendId'));
    }

    public function totalDetails($bookingId, $amendId) {

        $bookings = Bookings::query()
        ->where('booking_id', $bookingId)
        ->where('amend_id', $amendId)
        ->first();

        $check_in = Carbon::parse( $bookings->check_in); // Start date
        $check_out = Carbon::parse( $bookings->check_out);   // End date

        $days = $check_in->diffInDays($check_out) + 1; // Including both start and end date
        $nights = $check_in->diffInDays($check_out); 

        $total_pickup = PickupDetails::query()
        ->where('booking_id', $bookingId)
        ->sum('total_pickup_rate');

        $total_dropoff = DropoffDetails::query()
        ->where('booking_id', $bookingId)
        ->sum('total_dropoff_rate');

        $landTransfer = $bookings->pickup01_total + $bookings->pickup02_total + $bookings->pickup03_total+ $bookings->dropoff01_total + $bookings->dropoff02_total + $bookings->dropoff03_total + $total_pickup + $total_dropoff;

        // $total_optional = OptionalArrangementDetails::query()
        // ->where('booking_id', $bookingId)
        // ->sum('optional_total');

        // $total_optional_no_sst = OptionalArrangementDetails::query()
        // ->where('booking_id', $bookingId)
        // ->where('optional_sst', 0)
        // ->sum('optional_total');

        $find_total_optional = Bookings::query()
        ->where('booking_id', $bookingId)
        ->where('amend_id', $amendId)
        ->first();
        $optional01_total = 0;
        $optional02_total = 0;
        $optional03_total = 0;
        $optional04_total = 0;
        $optional05_total = 0;

        $optional01_total_no_sst = 0;
        $optional02_total_no_sst = 0;
        $optional03_total_no_sst = 0;
        $optional04_total_no_sst = 0;
        $optional05_total_no_sst = 0;

        if ($find_total_optional->optional01_GST == 1) {
            $optional01_total = $find_total_optional->optional01_total;
        } else {
            $optional01_total_no_sst = $find_total_optional->optional01_total;
        }

        if ($find_total_optional->optional02_GST == 1) {
            $optional02_total = $find_total_optional->optional02_total;
        } else {
            $optional02_total_no_sst = $find_total_optional->optional02_total;
        }

        if ($find_total_optional->optional03_GST == 1) {
            $optional03_total = $find_total_optional->optional03_total;
        } else {
            $optional03_total_no_sst = $find_total_optional->optional03_total;
        }

        if ($find_total_optional->optional04_GST == 1) {
            $optional04_total = $find_total_optional->optional04_total;
        } else {
            $optional04_total_no_sst = $find_total_optional->optional04_total;
        }

        if ($find_total_optional->optional05_GST == 1) {
            $optional05_total = $find_total_optional->optional05_total;
        } else {
            $optional05_total_no_sst = $find_total_optional->optional05_total;
        }

        // $total_optional = $find_total_optional->optional01_total + $find_total_optional->optional02_total + $find_total_optional->optional03_total + $find_total_optional->optional04_total + $find_total_optional->optional05_total;
        $total_optional = $optional01_total + $optional02_total + $optional03_total + $optional04_total + $optional05_total;
        $total_optional_no_sst = $optional01_total_no_sst + $optional02_total_no_sst + $optional03_total_no_sst + $optional04_total_no_sst + $optional05_total_no_sst;

        $optionalArrangements = $total_optional;

        $grand_total_with_sst = $landTransfer + $optionalArrangements + $bookings->package_total;

        $deposit = $grand_total_with_sst * 0.20;

        Bookings::query()
        ->where('booking_id', $bookingId)
        ->where('amend_id', $amendId)
        ->update([
            'landtransfer_total' => $landTransfer,
            'optional_total' => $optionalArrangements,
            'deposit_amount'  =>  $deposit,
        ]);

        $total_sst = ($bookings->package_total + $landTransfer + $total_optional) / 1.08 * 0.08;

        $total_amount_no_sst = $grand_total_with_sst - $total_sst;

        $amount_due = $grand_total_with_sst - $deposit;

        $receipts = receipt::query()
        ->where('booking_ID', $bookingId)
        ->get();

        $totalpay = $receipts->sum('amount');
        $lastpaid = receipt::query()
        ->where('booking_ID', $bookingId)
        ->orderBy('AI_ID', 'desc')
        ->first();

        // $countreceipt = $receipts->count();

        // if ($countreceipt == 0) {
        //     $latestReceipt = Receipt::query()
        //     ->where('ID', '>', 0)
        //     ->orderBy('AI_ID', 'desc')
        //     ->value('ID');

        //     receipt::insert([
        //         'ID'            => $latestReceipt + 1,
        //         'booking_ID'    => $bookingId,
        //         'paid_date'  => now(),
        //         'issue_date'  => now(),
        //         'payment_from'  =>  '',
        //         'amount'        =>  0,
        //     ]);

        // }

        return view('form5', compact('bookings', 'total_optional_no_sst', 'total_sst',  'grand_total_with_sst', 'days', 'nights', 'total_amount_no_sst', 'deposit', 'amount_due', 'amendId', 'receipts', 'totalpay', 'lastpaid'));
    }

    public function changeDeposit(Request $request,$id) {
        Bookings::query()
        ->where('booking_id', $id)
        ->update([
            'deposit_amount' => $request->value,
        ]);

        return response()->json(['success' => true, 'message' => 'Successfully updated']);
    }

    public function savePayment(Request $request, $bookingId) {
    
        // ✅ Loop through each receipt in the `receiptData` array
        foreach ($request->receiptData as $receipt) {
            // ✅ Validate required fields (ensure 'ai_id' exists)
            if (!isset($receipt['ai_id']) || !isset($receipt['date']) || !isset($receipt['amount'])) {
                continue; // Skip incomplete records
            }
    
            // ✅ Get Payment From
            $payment_for = 'Security Deposit for Booking ' . $bookingId;
            $payment_from = Bookings::query()
                ->where('booking_id', $bookingId)
                ->where('amend_id', $receipt['amend_id']) // Use `$receipt['amend_id']` instead of `$request->amend_id`
                ->value('company');
    
            // ✅ Update each record properly
            Receipt::query()
                ->where('booking_id', $bookingId)
                ->where('AI_ID', $receipt['ai_id'])
                ->update([
                    'amount'        => $receipt['amount'] ?? 0, // Convert empty values to `0`
                    'bank'          => $receipt['bank'] ?? null, // Convert empty to `NULL`
                    'bank_details'  => $receipt['bank_details'] ?? null,
                    'paid_date'     => $receipt['date'] ?? null,
                    'issue_date'    => now(),
                    'payment_for'   => $payment_for,
                    'payment_from'  => $payment_from
                ]);
        }
    
        return response()->json(['success' => true, 'message' => 'Successfully updated']);
    }

    public function addPayment(Request $request, $bookingId) {
        $latestReceipt = Receipt::query()
        ->where('ID', '>', 0)
        ->orderBy('AI_ID', 'desc')
        ->value('ID');

        $payment_for = 'Security Deposit for Booking ' . $bookingId;
        $payment_from = Bookings::query()
            ->select('company', 'attention')
            ->where('booking_id', $bookingId)
            ->where('amend_id', $request->amendId)
            ->first();
        
        $payment_from = $payment_from->company ? $payment_from->company : $payment_from->attention;

        $newReceipt = Receipt::create([
            'ID'            => $latestReceipt + 1,
            'booking_ID'    => $bookingId,
            'paid_date'     => $request->paymentDetails['date'],
            'issue_date'    => now(),
            'payment_from'  => $payment_from,
            'payment_for'   => $payment_for,
            'amount'        => $request->paymentDetails['amount'],
            'bank'          => $request->paymentDetails['bank'],
            'bank_details'  => $request->paymentDetails['bank_details'],
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Successfully updated',
            'receipt' => $newReceipt
        ]);    
    }

}
