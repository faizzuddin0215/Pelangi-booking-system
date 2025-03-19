<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CheckInReportController extends Controller
{
    public function index()
    {
        return view('check_in_report');
    }

    public function report(Request $request)
    {
        $fdate = $request->input('fromdate', now()->subMonth()->toDateString());
        $tdate = $request->input('todate', now()->toDateString());
        $search = $request->input('search', '');

        $bookings = DB::table('pelangi.bookings')
            ->leftJoin('bookings.rooms', 'pelangi.bookings.booking_id', '=', 'bookings.rooms.booking_id')
            ->where('pelangi.bookings.check_in', $fdate)
            ->where('pelangi.bookings.cancel', 0)
            ->where('pelangi.bookings.booking_id', 'like', '%' . $search . '%')
            ->select('pelangi.bookings.*', 'bookings.rooms.*')
            ->get()
            ->groupBy('booking_id')
            ->map(function ($bookingGroup) {
                // Initialize the room_type_count for the booking
                $roomTypeCount = [];

                // Loop through each room in the booking group
                foreach ($bookingGroup as $room) {
                    $roomTypeCount[$room->room_type] = ($roomTypeCount[$room->room_type] ?? 0) + 1;
                }
        
                $booking = $bookingGroup->first();
                $nights = (int)\Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out));
                $days = $nights + 1;
        
                $booking->room_type_count = $roomTypeCount;
                $booking->nights = $nights;
                $booking->days = $days;
                // Return the booking group (you can just return the first room as the booking)
                return $bookingGroup;
            });
        
        $sumpax = Bookings::query()
            ->select(
                DB::raw('SUM(pax_adult) as sum_pax_adult'),
                DB::raw('SUM(pax_child) as sum_pax_child'),
                DB::raw('SUM(pax_toddler) as sum_pax_toddler'),
                DB::raw('SUM(pax_foc_tl) as sum_pax_foc_tl')
            )
            ->whereDate('check_in', $fdate)
            ->get() // Returns a collection
            ->first(); // Get the first (and only) result
        
        // Ensure $sumpax is not null before accessing its properties
        $sumpax = [
            'sumpax_adult' => $sumpax->sum_pax_adult ?? 0,
            'sumpax_child' => $sumpax->sum_pax_child ?? 0,
            'sumpax_toddler' => $sumpax->sum_pax_toddler ?? 0,
            'sumpax_tl' => $sumpax->sum_pax_foc_tl ?? 0
        ];
        
        $rooms = Room::query()
            ->where('check_in', $fdate)
            ->where('booking_id', 'like', '%' . $search . '%')
            ->get();

        // $start_date = Carbon::parse($fdate);
        // $end_date = Carbon::parse($bookings->check_out);

        // // Calculate the number of days
        // $days = $start_date->diffInDays($end_date);

        // // Calculate the number of nights (days - 1)
        // $nights = max(0, $days - 1);

        return view('check_in_report', compact('bookings', 'fdate', 'tdate', 'search', 'rooms', 'sumpax'));
    }

    public function filter(Request $request)
    {
        return redirect()->route('check_in_report', [
            'fromdate' => $request->fromdate,
            'todate' => $request->todate,
            'search' => $request->search,
        ]);
    }
}
