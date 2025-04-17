<?php

namespace App\Http\Controllers;

use App\Models\receipt;
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
            ->groupBy('booking_id');

            $receipts = receipt::whereIn('booking_ID', $booking_details->keys())->get()->groupBy('booking_ID');

            $generate_time = Carbon::now()->format('d/m/Y H:i:s');

        return view('payment_summary_report', compact('booking_details', 'fdate', 'tdate', 'search', 'generate_time', 'receipts'));
    }


}
