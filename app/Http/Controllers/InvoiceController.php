<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\DropoffDetails;
use App\Models\NamelistUser;
use App\Models\PickupDetails;
use App\Models\receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class InvoiceController extends Controller
{
    public function invoice($bookingId, $amendId) {
        // Use the bookingId for logic or pass it to the view
        return view('invoice', compact('bookingId', 'amendId'));
    }

    public function totalDetailsInvoice($bookingId, $amendId) {

        $bookings = Bookings::query()
        ->where('booking_id', $bookingId)
        ->where('amend_id', $amendId)
        ->first();

        $password = NamelistUser::query()
        ->where('booking_ID', $bookingId)
        ->value('password');

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

        $countreceipt = $receipts->count();

        if ($countreceipt == 0) {
            $latestReceipt = Receipt::query()
            ->where('ID', '>', 0)
            ->orderBy('AI_ID', 'desc')
            ->value('ID');

            receipt::insert([
                'ID'            => $latestReceipt + 1,
                'booking_ID'    => $bookingId,
                'paid_date'  => now(),
                'issue_date'  => now(),
                'payment_from'  =>  '',
                'amount'        =>  0,
            ]);

        }

        return view('invoice', compact('bookings', 'total_optional_no_sst', 'total_sst',  'grand_total_with_sst', 'days', 'nights', 'total_amount_no_sst', 'deposit', 'amount_due', 'amendId', 'receipts', 'totalpay', 'lastpaid', 'password'));
    }

}
