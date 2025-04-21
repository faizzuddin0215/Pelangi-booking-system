<?php

namespace App\Http\Controllers;

use App\Models\receipt;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PaxReportController extends Controller
{
    public function index()
    {
        $bookings = collect(); 
        return view('pax_report', compact('bookings'));
    }

    public function report(Request $request)
    {
        $fdate = '';
        $tdate = '';

        $duration = '';
        
        $results = [];
        
        $rooms = 0;

        $formatted_fdate = Carbon::now();

        return view('pax_report', compact('results', 'fdate', 'tdate', 'duration', 'rooms', 'formatted_fdate'));
    }

    public function filter(Request $request)
    {
        $duration = $request->duration ?? '';
        $fdate = Carbon::parse($request->input('fromdate', now()->subMonth()->toDateString()));
        info($fdate);
        if ($duration == '7_days') {
            $tdate = Carbon::parse($fdate)->addDays(7)->toDateString();
        } else {
            $tdate = Carbon::parse($fdate)->addMonth()->toDateString();
        }
        // Define the start and end date for the month
        // $fdate = Carbon::create(2024, 3, 1);
        // $tdate = Carbon::create(2024, 3, 7);
        // Generate a collection of all days in March 2024
        $days = collect();
        $currentDate = $fdate;
        while ($currentDate <= $tdate) {
            $days->push($currentDate->copy());
            $currentDate->addDay();
        }

        // Get the total passengers for check-in, in-house, and check-out for each day
        $results = $days->map(function ($day) {
            // Check-in count
            $checkInCount = DB::table('bookings')
                ->whereDate('check_in', $day)
                ->where('cancel', 0)
                ->sum(DB::raw('pax_adult + pax_child + pax_toddler + pax_foc_tl'));

            $checkInCountChild = DB::table('bookings')
                ->whereDate('check_in', $day)
                ->where('cancel', 0)
                ->sum(DB::raw('pax_child'));

            // In-house count (check-in <= day and check-out > day)
            $inHouseCount = DB::table('bookings')
                ->whereDate('check_in', '<', $day)
                ->whereDate('check_out', '>', $day)
                ->where('cancel', 0)
                ->sum(DB::raw('pax_adult + pax_child + pax_toddler + pax_foc_tl'));

            $inHouseCountChild = DB::table('bookings')
                ->whereDate('check_in', '<', $day)
                ->whereDate('check_out', '>', $day)
                ->where('cancel', 0)
                ->sum(DB::raw('pax_child'));

            // Check-out count
            $checkOutCount = DB::table('bookings')
                ->whereDate('check_out', $day)
                ->where('cancel', 0)
                ->sum(DB::raw('pax_adult + pax_child + pax_toddler + pax_foc_tl'));

            $checkOutCountChild = DB::table('bookings')
                ->whereDate('check_out', $day)
                ->where('cancel', 0)
                ->sum(DB::raw('pax_child'));

            $roomsCheckInCount = Room::query()
                ->whereDate('check_in', $day)
                ->where('room_type', 'NOT LIKE', 'TL%')
                ->count('*');

            // In-house count (check-in <= day and check-out > day)
            $roomsInHouseCount = Room::query()
                ->whereDate('check_in', '<', $day)
                ->whereDate('check_out', '>', $day)
                ->where('room_type', 'NOT LIKE', 'TL%')
                ->count('*');

            // Check-out count
            $roomsCheckOutCount = Room::query()
                ->whereDate('check_out', $day)
                ->where('room_type', 'NOT LIKE', 'TL%')
                ->count('*');

            return [
                'day' => $day->format('j/n/Y'),
                'check_in_count' => $checkInCount,
                'in_house_count' => $inHouseCount,
                'check_out_count' => $checkOutCount,
                'check_in_count_child' => $checkInCountChild,
                'in_house_count_child' => $inHouseCountChild,
                'check_out_count_child' => $checkOutCountChild,
                'room_check_in_count' => $roomsCheckInCount,
                'room_in_house_count' => $roomsInHouseCount,
                'room_check_out_count' => $roomsCheckOutCount
            ];

        });
        $generate_time = Carbon::now()->format('d/m/Y H:i:s');
        $formatted_fdate = Carbon::parse($request->input('fromdate', now()->subMonth()->toDateString()))
        ->toDateString();
        info($formatted_fdate);
        return view('pax_report', compact('results', 'fdate', 'tdate', 'duration', 'generate_time', 'formatted_fdate'));

    }
}
