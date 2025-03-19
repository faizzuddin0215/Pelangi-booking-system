<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return view('check_in_out_report');
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
            ->groupBy('booking_id');
        
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

        $dropoffs = DB::table('pelangi.bookings')
            ->leftJoin('bookings.rooms', 'pelangi.bookings.booking_id', '=', 'bookings.rooms.booking_id')
            ->where('pelangi.bookings.check_out', $fdate)
            ->where('pelangi.bookings.cancel', 0)
            ->where('pelangi.bookings.booking_id', 'like', '%' . $search . '%')
            ->select('pelangi.bookings.*', 'bookings.rooms.*')
            ->get()
            ->groupBy('booking_id');
        
        $sumpax_dropoff = Bookings::query()
            ->select(
                DB::raw('SUM(pax_adult) as sum_pax_adult'),
                DB::raw('SUM(pax_child) as sum_pax_child'),
                DB::raw('SUM(pax_toddler) as sum_pax_toddler'),
                DB::raw('SUM(pax_foc_tl) as sum_pax_foc_tl')
            )
            ->whereDate('check_out', $fdate)
            ->get() // Returns a collection
            ->first(); // Get the first (and only) result
        
        // Ensure $sumpax is not null before accessing its properties
        $sumpax_dropoff = [
            'sumpax_dropoff_adult' => $sumpax_dropoff->sum_pax_adult ?? 0,
            'sumpax_dropoff_child' => $sumpax_dropoff->sum_pax_child ?? 0,
            'sumpax_dropoff_toddler' => $sumpax_dropoff->sum_pax_toddler ?? 0,
            'sumpax_dropoff_tl' => $sumpax_dropoff->sum_pax_foc_tl ?? 0
        ];

        
        $rooms = Room::query()
            ->where('check_in', $fdate)
            ->where('booking_id', 'like', '%' . $search . '%')
            ->get();

        return view('check_in_out_report', compact('bookings', 'dropoffs', 'fdate', 'tdate', 'search', 'rooms', 'sumpax', 'sumpax_dropoff'));
    }

    public function filter(Request $request)
    {
        return redirect()->route('check_in_out_report', [
            'fromdate' => $request->fromdate,
            'todate' => $request->todate,
            'search' => $request->search,
        ]);
    }
}
