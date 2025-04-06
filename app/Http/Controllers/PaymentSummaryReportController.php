<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PaymentSummaryReportController extends Controller
{
    public function index()
    {
        $bookings = collect(); 
        return view('payment_summary_report', compact('bookings'));
    }

    public function report(Request $request)
    {
        $fdate = '';
        $tdate = '';

        $search = '';
        
        $booking_details = [];
        
        $rooms = 0;

        return view('payment_summary_report', compact('booking_details', 'fdate', 'tdate', 'search', 'rooms'));
    }

    public function filter(Request $request)
    {
        $fdate = Carbon::parse($request->input('fromdate', now()->subMonth()->toDateString()));
        $tdate = Carbon::parse($fdate)->addDays(6)->toDateString();
        $search = $request->search ?? '';

            $booking_details = DB::table('pelangi.bookings')
            ->leftJoin('bookings.rooms', 'pelangi.bookings.booking_id', '=', 'bookings.rooms.booking_id')
            ->whereBetween('pelangi.bookings.check_in', [$fdate, $tdate])
            ->where('pelangi.bookings.booking_id', 'like', '%' . $search . '%')
            ->where('pelangi.bookings.cancel', 0)
            ->orderBy('pelangi.bookings.check_in')
            ->get()
            ->groupBy('booking_id')
            ->map(function ($bookingGroup) {
                // Initialize the room_type_count for the booking
                $roomTypeCount = [];

                // Loop through each room in the booking group
                foreach ($bookingGroup as $room) {
                    // Increment the count for the room_type in the roomTypeCount array
                    if (isset($roomTypeCount[$room->room_type])) {
                        $roomTypeCount[$room->room_type]++;
                    } else {
                        $roomTypeCount[$room->room_type] = 1;
                    }
                }

                // Add the room_type_count to the booking group
                $bookingGroup[0]->room_type_count = $roomTypeCount;

                // Return the booking group (you can just return the first room as the booking)
                return $bookingGroup;
            });

            $generate_time = Carbon::now()->format('d/m/Y H:i:s');

        return view('payment_summary_report', compact('booking_details', 'fdate', 'tdate', 'search', 'generate_time'));
    }


}
