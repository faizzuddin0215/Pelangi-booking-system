<?php

namespace App\Http\Controllers;

use App\Models\OptionalArrangement;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DailyGuestSumReportController extends Controller
{
    public function index()
    {
        $bookings = collect(); 
        return view('daily_guest_sum_report', compact('bookings'));
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

        return view('daily_guest_sum_report', compact('checkIn', 'inHouse', 'checkOut', 'fdate', 'tdate', 'duration', 'rooms', 'formatted_fdate'));
    }

    public function filter(Request $request)
    {
        $fdate = $request->fromdate;

        // Check-in count
        // $checkIn = DB::table('pelangi.bookings')
        //     ->whereDate('check_in', $fdate)
        //     ->where('cancel', 0)
        //     ->get();

        $checkIn = DB::table('pelangi.bookings')
        ->leftJoin('bookings.rooms', 'pelangi.bookings.booking_id', '=', 'bookings.rooms.booking_id')
        ->where('pelangi.bookings.check_in', $fdate)
        ->where('pelangi.bookings.cancel', 0)
        ->select(
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
            'pelangi.bookings.pax_child',
            'pelangi.bookings.internal_remarks',
            'bookings.rooms.rooms',
            'bookings.rooms.room_type',
            'pelangi.bookings.optional01_desc',
            'pelangi.bookings.optional02_desc',
            'pelangi.bookings.optional03_desc',
            'pelangi.bookings.optional04_desc',
            'pelangi.bookings.optional05_desc',
            'pelangi.bookings.balance_amount',
        )
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

            $bookingGroup[0]->optional_code = OptionalArrangement::query()
            ->where('optional_name', $bookingGroup[0]->optional01_desc)
            ->value('optional_code');

            $bookingGroup[0]->optional_code2 = OptionalArrangement::query()
            ->where('optional_name', $bookingGroup[0]->optional02_desc)
            ->value('optional_code');

            $bookingGroup[0]->optional_code3 = OptionalArrangement::query()
            ->where('optional_name', $bookingGroup[0]->optional03_desc)
            ->value('optional_code');

            $bookingGroup[0]->optional_code4 = OptionalArrangement::query()
            ->where('optional_name', $bookingGroup[0]->optional04_desc)
            ->value('optional_code');

            $bookingGroup[0]->optional_code5 = OptionalArrangement::query()
            ->where('optional_name', $bookingGroup[0]->optional05_desc)
            ->value('optional_code');

            
            // Return the booking group (you can just return the first room as the booking)
            return $bookingGroup;
        });
        
        $inHouse = DB::table('pelangi.bookings')
        ->leftJoin('bookings.rooms', 'pelangi.bookings.booking_id', '=', 'bookings.rooms.booking_id')
        ->where('pelangi.bookings.check_in', '<', $fdate)
        ->where('pelangi.bookings.check_out', '>', $fdate)
        ->where('pelangi.bookings.cancel', 0)
        ->select(
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
            'pelangi.bookings.pax_child',
            'pelangi.bookings.internal_remarks',
            'bookings.rooms.rooms',
            'bookings.rooms.room_type',
            'pelangi.bookings.optional01_desc',
            'pelangi.bookings.optional02_desc',
            'pelangi.bookings.optional03_desc',
            'pelangi.bookings.optional04_desc',
            'pelangi.bookings.optional05_desc',
            'pelangi.bookings.balance_amount',
        )
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

            $bookingGroup[0]->optional_code = OptionalArrangement::query()
            ->where('optional_name', $bookingGroup[0]->optional01_desc)
            ->value('optional_code');

            $bookingGroup[0]->optional_code2 = OptionalArrangement::query()
            ->where('optional_name', $bookingGroup[0]->optional02_desc)
            ->value('optional_code');

            $bookingGroup[0]->optional_code3 = OptionalArrangement::query()
            ->where('optional_name', $bookingGroup[0]->optional03_desc)
            ->value('optional_code');

            $bookingGroup[0]->optional_code4 = OptionalArrangement::query()
            ->where('optional_name', $bookingGroup[0]->optional04_desc)
            ->value('optional_code');

            $bookingGroup[0]->optional_code5 = OptionalArrangement::query()
            ->where('optional_name', $bookingGroup[0]->optional05_desc)
            ->value('optional_code');

            
            // Return the booking group (you can just return the first room as the booking)
            return $bookingGroup;
        });

        $checkOut = DB::table('pelangi.bookings')
        ->leftJoin('bookings.rooms', 'pelangi.bookings.booking_id', '=', 'bookings.rooms.booking_id')
        ->where('pelangi.bookings.check_out', $fdate)
        ->where('pelangi.bookings.cancel', 0)
        ->select(
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
            'pelangi.bookings.pax_child',
            'pelangi.bookings.internal_remarks',
            'bookings.rooms.rooms',
            'bookings.rooms.room_type',
            'pelangi.bookings.optional01_desc',
            'pelangi.bookings.optional02_desc',
            'pelangi.bookings.optional03_desc',
            'pelangi.bookings.optional04_desc',
            'pelangi.bookings.optional05_desc',
            'pelangi.bookings.balance_amount',
        )
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

            $bookingGroup[0]->optional_code = OptionalArrangement::query()
            ->where('optional_name', $bookingGroup[0]->optional01_desc)
            ->value('optional_code');

            $bookingGroup[0]->optional_code2 = OptionalArrangement::query()
            ->where('optional_name', $bookingGroup[0]->optional02_desc)
            ->value('optional_code');

            $bookingGroup[0]->optional_code3 = OptionalArrangement::query()
            ->where('optional_name', $bookingGroup[0]->optional03_desc)
            ->value('optional_code');

            $bookingGroup[0]->optional_code4 = OptionalArrangement::query()
            ->where('optional_name', $bookingGroup[0]->optional04_desc)
            ->value('optional_code');

            $bookingGroup[0]->optional_code5 = OptionalArrangement::query()
            ->where('optional_name', $bookingGroup[0]->optional05_desc)
            ->value('optional_code');

            
            // Return the booking group (you can just return the first room as the booking)
            return $bookingGroup;
        });
        
        $generate_time = Carbon::now()->format('d/m/Y H:i:s');
        $formatted_fdate = Carbon::parse($request->input('fromdate', now()->subMonth()->toDateString()))
        ->toDateString();
        return view('daily_guest_sum_report', compact('checkIn', 'inHouse', 'checkOut', 'fdate', 'generate_time', 'formatted_fdate'));

    }
}
