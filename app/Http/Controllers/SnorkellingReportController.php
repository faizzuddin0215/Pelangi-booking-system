<?php

namespace App\Http\Controllers;

use App\Models\OptionalArrangement;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SnorkellingReportController extends Controller
{
    public function index()
    {
        $bookings = collect(); 
        return view('snorkelling_report', compact('bookings'));
    }

    public function report(Request $request)
    {
        $fdate = '';
        $tdate = '';

        $duration = '';
        
        $checkIn = [];
        $inHouse = [];
        $checkOut = [];
        
        $rooms = 0;

        $formatted_fdate = Carbon::now();

        return view('snorkelling_report', compact('checkIn', 'inHouse', 'checkOut', 'fdate', 'tdate', 'duration', 'rooms', 'formatted_fdate'));
    }

    public function filter(Request $request)
    {
        $fdate = $request->fromdate;
    
        // Reusable query logic
        $selectFields = [
            'pelangi.bookings.booking_id',
            'pelangi.bookings.check_in',
            'pelangi.bookings.check_out',
            'bookings.rooms.nights',
            'pelangi.bookings.group_name',
            'pelangi.bookings.company',
            'pelangi.bookings.pax_adult',
            'pelangi.bookings.pax_child',
            'pelangi.bookings.pax_toddler',
            'pelangi.bookings.pax_foc_tl',
            'pelangi.bookings.internal_remarks',
            'bookings.rooms.rooms',
            'bookings.rooms.room_type',
            'pelangi.bookings.optional01_desc',
            'pelangi.bookings.optional02_desc',
            'pelangi.bookings.optional03_desc',
            'pelangi.bookings.optional04_desc',
            'pelangi.bookings.optional05_desc',
            'pelangi.bookings.optional01_pax',
            'pelangi.bookings.optional02_pax',
            'pelangi.bookings.optional03_pax',
            'pelangi.bookings.optional04_pax',
            'pelangi.bookings.optional05_pax',
            'pelangi.bookings.balance_amount',
        ];
    
        // Mapping logic extraction
        $mapBookingGroup = function ($bookingGroup) {
            $roomTypeCount = [];
    
            foreach ($bookingGroup as $room) {
                $roomTypeCount[$room->room_type] = ($roomTypeCount[$room->room_type] ?? 0) + 1;
            }
    
            $booking = $bookingGroup[0];
            $booking->room_type_count = $roomTypeCount;
    
            for ($i = 1; $i <= 5; $i++) {
                $desc = "optional0{$i}_desc";
                $codeField = "optional_code{$i}";
                $query = OptionalArrangement::query()->where('optional_name', $booking->$desc);
                if ($i === 1) {
                    $query->where('dive_package', 1);
                }
                $booking->$codeField = $query->value('optional_code');
            }
    
            $booking->dive_package = collect([
                $booking->optional_code1,
                $booking->optional_code2,
                $booking->optional_code3,
                $booking->optional_code4,
                $booking->optional_code5
            ])->filter()->isNotEmpty() ? 1 : 0;

    
            return $bookingGroup;
        };
    
        // Get check-in bookings
        $checkIn = DB::table('pelangi.bookings')
            ->leftJoin('bookings.rooms', 'pelangi.bookings.booking_id', '=', 'bookings.rooms.booking_id')
            ->whereDate('pelangi.bookings.check_in', $fdate)
            ->where('pelangi.bookings.cancel', 0)
            ->select($selectFields)
            ->orderBy('pelangi.bookings.check_in')
            ->get()
            ->groupBy('booking_id')
            ->map($mapBookingGroup);
    
        // Get in-house bookings
        $inHouse = DB::table('pelangi.bookings')
            ->leftJoin('bookings.rooms', 'pelangi.bookings.booking_id', '=', 'bookings.rooms.booking_id')
            ->where('pelangi.bookings.check_in', '<', $fdate)
            ->where('pelangi.bookings.check_out', '>', $fdate)
            ->where('pelangi.bookings.cancel', 0)
            ->select($selectFields)
            ->orderBy('pelangi.bookings.check_in')
            ->get()
            ->groupBy('booking_id')
            ->map($mapBookingGroup);
    
        // Get check-out bookings
        $checkOut = DB::table('pelangi.bookings')
            ->leftJoin('bookings.rooms', 'pelangi.bookings.booking_id', '=', 'bookings.rooms.booking_id')
            ->whereDate('pelangi.bookings.check_out', $fdate)
            ->where('pelangi.bookings.cancel', 0)
            ->select($selectFields)
            ->orderBy('pelangi.bookings.check_in')
            ->get()
            ->groupBy('booking_id')
            ->map($mapBookingGroup);
    
        // Generate time
        $generate_time = Carbon::now()->format('d/m/Y H:i:s');
        $formatted_fdate = Carbon::parse($request->input('fromdate', now()->subMonth()->toDateString()))->toDateString();
    
        return view('snorkelling_report', compact('checkIn', 'inHouse', 'checkOut', 'fdate', 'generate_time', 'formatted_fdate'));
    }
    }
