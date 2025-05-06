<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\namelist;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class NameListReportController extends Controller
{
    public function index()
    {
        $bookings = collect(); 
        return view('name_list_report', compact('bookings'));
    }

    public function report(Request $request)
    {
        $fdate = $request->input('fromdate', now()->subMonth()->toDateString());
        $tdate = $request->input('todate', now()->toDateString());
        $search = $request->input('search', '');

        // $booking = Bookings::query()
        // ->where('check_in', $fdate)
        // ->get();

        $name_list_details = namelist::query()
        ->orderBy('nameListID', 'desc')
        ->paginate(50);

        // $name_list_details = DB::connection('mysql3')->table('name_list')
        // ->join('bookings', 'name_list.bookingID', '=', 'bookings.booking_id')
        // ->where('bookings.check_in', $fdate)
        // ->orderBy('name_list.nameListID', 'desc')
        // ->select('name_list.*', 'bookings.*')
        // ->paginate(50);

        $generate_time = Carbon::now()->format('d/m/Y H:i:s');

        return view('name_list_report', compact('name_list_details', 'generate_time', 'fdate', 'search'));
    }

    public function filter(Request $request)
    {
        $fdate = Carbon::parse($request->input('fromdate', now()->subMonth()->toDateString()));
        $tdate = Carbon::parse($fdate)->addDays(6)->toDateString();
        $search = $request->search ?? '';


        $name_list_details = namelist::query()
        ->get();

        $generate_time = Carbon::now()->format('d/m/Y H:i:s');

        return view('name_list_report', compact('name_list_details', 'fdate', 'tdate', 'search', 'generate_time'));
    }


}
