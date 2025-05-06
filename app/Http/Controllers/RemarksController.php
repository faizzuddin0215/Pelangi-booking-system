<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Dropoff;
use App\Models\DropoffDetails;
use App\Models\OptionalArrangement;
use App\Models\OptionalArrangementDetails;
use App\Models\Pickup;
use App\Models\PickupDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RemarksController extends Controller
{
    public function form4($bookingId, $amendId) {
        // Use the bookingId for logic or pass it to the view
        return view('form4', compact('bookingId','amendId'));
    }

    public function bookingDetails($bookingId, $amendId) {
        $pickups = PickupDetails::where('booking_id', $bookingId)->get();
        $total_pickup = number_format($pickups->sum('total_pickup_rate'), 2);

        $dropoffs = DropoffDetails::where('booking_id', $bookingId)->get();
        $total_dropoff = number_format($dropoffs->sum('total_dropoff_rate'), 2);

        $pickupOptions = Pickup::pluck('pickup_name');
        $dropoffOptions = Dropoff::pluck('dropoff_name');
        $optionalOptions = OptionalArrangement::pluck('optional_name');
        $bookings = Bookings::query()
        ->where('booking_id', $bookingId)
        ->where('amend_id', $amendId)
        ->first();

        $optionalArrangements = OptionalArrangementDetails::where('booking_id', $bookingId)->get();
        $optionalbooking_total = $bookings->optional01_total + $bookings->optional02_total + $bookings->optional03_total + $bookings->optional04_total + $bookings->optional05_total;
        $optionalArrangementstotal = $optionalArrangements->sum('optional_total');
        $total_optional = number_format($optionalbooking_total + $optionalArrangementstotal, 2);

        $check_in = Carbon::parse( $bookings->check_in); // Start date
        $check_out = Carbon::parse( $bookings->check_out);   // End date

        $days = $check_in->diffInDays($check_out) + 1; // Including both start and end date
        $nights = $check_in->diffInDays($check_out); 

        $total_pickup = $pickups->sum('total_pickup_rate');

        $total_pickup = number_format($total_pickup + $bookings->pickup01_total + $bookings->pickup02_total + $bookings->pickup03_total, 2);

        $total_dropoff = $dropoffs->sum('total_dropoff_rate');

        $total_dropoff = number_format($total_dropoff + $bookings->dropoff01_total + $bookings->dropoff02_total + $bookings->dropoff03_total, 2);

        $package_total = number_format($bookings->package_total, 2);
        $land_transfer_total = number_format($total_pickup + $total_dropoff, 2);
        $optional_total = $total_optional;
        $total_summary = number_format($bookings->package_total + $total_pickup + $total_dropoff + $optionalArrangements->sum('optional_total'), 2);

        return view('form4', compact('bookings', 'days', 'nights', 'package_total', 'land_transfer_total', 'optional_total', 'total_summary', 'amendId'));
    }

    public function save(Request $request, $bookingId) {
        Bookings::query()
        ->where('booking_id', $bookingId)
        ->where('amend_id', $request->amendid)
        ->update([
            'remarks_customer' => $request->remarks_customer,
            'internal_remarks' => $request->internal_remarks,
            'divecentre_remarks' => $request->divecentre_remarks,
        ]);

        return response()->json([
            'success' => true
        ]);    }

    public function updateField(Request $request, $bookingId) {
        // Allowed fields to update
        $allowedFields = ['remarks_customer', 'internal_remarks', 'divecentre_remarks', 'amend01', 'amend02', 'amend03', 'amend04', 'amend05', 'amend06', 'amend07', 'amend08', 'amend09', 'amend10'];

        if (!in_array($request->field, $allowedFields)) {
            return response()->json(['error' => 'Invalid field'], 400);
        }

        // Update the specific field dynamically
        // if ($request->amendid == 0) {
            Bookings::where('booking_id', $bookingId)
            ->where('amend_id', $request->amendid)
            ->update([$request->field => $request->value]);
        // } else {
        //     BookingsAmend::where('booking_id', $bookingId)
        //     ->where('amend_id', $request->amendid)
        //     ->update([$request->field => $request->value]);
        // }

        return response()->json(['message' => ucfirst(str_replace('_', ' ', $request->field)) . ' updated successfully!']);
    }

    public function optionalDetails($bookingId) {
        $optionalArrangements = OptionalArrangementDetails::where('booking_id', $bookingId)->get();
        $total_optional = number_format($optionalArrangements->sum('optional_total'), 2);

        $optionalOptions = OptionalArrangement::pluck('optional_name');
        return view('form4', compact('optionalArrangements', 'optionalOptions', 'total_optional'));
    }

}
