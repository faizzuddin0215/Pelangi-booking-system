<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\BookingsAmend;
use App\Models\Dropoff;
use App\Models\DropoffDetails;
use App\Models\Leads;
use App\Models\NamelistUser;
use App\Models\OptionalArrangement;
use App\Models\OptionalArrangementDetails;
use App\Models\OptionalCodeBooking;
use App\Models\Pickup;
use App\Models\PickupDetails;
use App\Models\Rates;
use App\Models\receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class FormController extends Controller
{
    public function index()
    {
        return view('form');
    }
    
    public function submit(Request $request)
    {
        if ($request['bookingid'] == '') {
            $date = $request['date'];
            $carbonDate = Carbon::createFromFormat('d/m/Y', $date);
    
            // Format the date to 'Y-m-d' (or any other format)
            $formattedDate = $carbonDate->format('Y-m-d');
    
            $booking = Bookings::create([
                'attention' => $request['name'],
                'company' => $request['company'],
                'address' => $request['address'] ? $request['address'] : '',
                'telephone' => $request['telephone'],
                'fax' => $request['fax'],
                'email' => $request['email'],
                'group_name' => $request['contactname'],
                'group_contact' => $request['contactno'],
                'handle_by' => $request['handleby'],
                'date' => $formattedDate,
                'leads' => $request['lead'] ? $request['lead'] : 0,
                'cancel' => $request['cancel'],
                'agent' => $request['agent'],
                'dive_pckg' => 0,
                'insurance' => 0,
                // 'check_in' => 0,
                // 'check_out' => 0,
                'pax_adult' => 0,
                'pax_child' => 0,
                'pax_toddler' => 0,
                'pax_foc_tl' => 0
            ]);

            // Get the latest booking ID
            $bookingId = Bookings::query()
            ->orderBy('booking_id', 'desc')
            ->limit(1)
            ->pluck('booking_id')  // Get just the 'booking_id' column
            ->first();

            NamelistUser::insert([
                'booking_ID' => $bookingId,
                'password'   => $request['password'],
                'group_name' => $request['contactname'] ?? '',
                'group_contact' => $request['contactno'] ?? '',
                'check_in' => !empty($request['check_in']) ? $request['check_in'] : now(),
                'check_out' => !empty($request['check_out']) ? $request['check_out'] : now(),
                'pax_adult' => $request['adult'] ?? 0,
                'pax_child' => $request['child'] ?? 0,
                'pax_toddler' => $request['toddler'] ?? 0,
                'pax_foc_tl' => $request['tl'] ?? 0,
                'company_ID' => 0,
                'grand_total' => 0,
                'total_paid' => 0,
                'actual_balance' => 0,
                'no_pax_adult' => 0,
                'no_pax_child' => 0
            ]);


            //create 4 rows of pickup and dropoff
            PickupDetails::create([
                'booking_id' => $bookingId
            ]);
            PickupDetails::create([
                'booking_id' => $bookingId
            ]);
            PickupDetails::create([
                'booking_id' => $bookingId
            ]);
            PickupDetails::create([
                'booking_id' => $bookingId
            ]);

            DropoffDetails::create([
                'booking_id' => $bookingId
            ]);
            DropoffDetails::create([
                'booking_id' => $bookingId
            ]);
            DropoffDetails::create([
                'booking_id' => $bookingId
            ]);
            DropoffDetails::create([
                'booking_id' => $bookingId
            ]);

            // create 4 row of optional arrangement
            OptionalArrangementDetails::create([
                'booking_id' => $bookingId
            ]);
            OptionalArrangementDetails::create([
                'booking_id' => $bookingId
            ]);
            OptionalArrangementDetails::create([
                'booking_id' => $bookingId
            ]);
            OptionalArrangementDetails::create([
                'booking_id' => $bookingId
            ]);

        } else {
            // if ($request->amendid) {
            //     $updated = BookingsAmend::query()
            //     ->where('booking_id', $request->bookingid)
            //     ->where('amend_id', $request->amendid)
            //     ->update([
            //         'attention' => $request['name'],
            //         'company' => $request['company'],
            //         'address' => $request['address'] ? $request['address'] : 'null',
            //         'telephone' => $request['telephone'],
            //         'fax' => $request['fax'],
            //         'email' => $request['email'],
            //         'group_name' => $request['contactname'],
            //         'group_contact' => $request['contactno'],
            //         'handle_by' => $request['handleby'],
            //         'date' => $request['date'],
            //         'leads' => $request['lead'] ? $request['lead'] : 0,
            //         'cancel' => $request['cancel'],
            //         'agent' => $request['agent'] ?? 0,
            //         'dive_pckg' => $request['divepackage'] ?? 0,
            //         'insurance' => $request['insurance'] ?? 0,
            //         // 'check_in' => !empty($request['check_in']) ? $request['check_in'] : now(),
            //         // 'check_out' => !empty($request['check_out']) ? $request['check_out'] : now(),
            //         // 'pax_adult' => $request['adult'] ?? 0,
            //         // 'pax_child' => $request['child'] ?? 0,
            //         // 'pax_toddler' => $request['toddler'] ?? 0,
            //         // 'pax_foc_tl' => $request['tl'] ?? 0
            //     ]);

            //     $bookingId = $request->bookingid;            

            //     $bookingDetails = BookingsAmend::query()
            //     ->where('booking_id', $request->bookingid)
            //     ->where('amend_id', $request->amendid)
            //     ->first();
            // } else {
            $updated = Bookings::query()
            ->where('booking_id', $request->bookingid)
            ->where('amend_id', $request->amendid)
            ->update([
                'attention' => $request['name'],
                'company' => $request['company'],
                'address' => $request['address'] ? $request['address'] : 'null',
                'telephone' => $request['telephone'],
                'fax' => $request['fax'],
                'email' => $request['email'],
                'group_name' => $request['contactname'],
                'group_contact' => $request['contactno'],
                'handle_by' => $request['handleby'],
                'date' => $request['date'],
                'leads' => $request['lead'] ? $request['lead'] : 0,
                'cancel' => $request['cancel'],
                'agent' => $request['agent'] ?? 0,
                'dive_pckg' => $request['divepackage'] ?? 0,
                'insurance' => $request['insurance'] ?? 0,
                // 'check_in' => !empty($request['check_in']) ? $request['check_in'] : now(),
                // 'check_out' => !empty($request['check_out']) ? $request['check_out'] : now(),
                // 'pax_adult' => $request['adult'] ?? 0,
                // 'pax_child' => $request['child'] ?? 0,
                // 'pax_toddler' => $request['toddler'] ?? 0,
                // 'pax_foc_tl' => $request['tl'] ?? 0
            ]);

            $bookingId = $request->bookingid;            

            $bookingDetails = Bookings::query()
            ->where('booking_id', $request->bookingid)
            ->where('amend_id', $request->amendid)
            ->first();
            // }
            NamelistUser::query()
            ->where('booking_id', $request->bookingid)
            ->update([
                'booking_ID' => $bookingId,
                'password'   => $request['password'],
                'group_name' => $request['contactname'] ?? '',
                'group_contact' => $request['contactno'] ?? '',
                // 'check_in' => $request['check_in'],
                // 'check_out' => $request['check_out'],
                // 'pax_adult' => $request['adult'] ?? 0,
                // 'pax_child' => $request['child'] ?? 0,
                // 'pax_toddler' => $request['toddler'] ?? 0,
                // 'pax_foc_tl' => $request['tl'] ?? 0,
                'company_ID' => 0,
                'grand_total' => 0,
                'total_paid' => 0,
                'actual_balance' => 0,
                'no_pax_adult' => 0,
                'no_pax_child' => 0
            ]);

            if ($bookingDetails->optional01_desc) {
                
                OptionalArrangementDetails::updateOrCreate(
                    ['optional_desc' => $bookingDetails->optional01_desc,
                     'booking_id' => $bookingId
                    ],
                    ['booking_id' => $request->bookingid,
                    'optional_desc' => $bookingDetails->optional01_desc,
                    'optional_sst' => $bookingDetails->optional01_GST,
                    'optional_code' => $bookingDetails->optional01_bill_to,
                    'optional_qty' => $bookingDetails->optional01_pax,
                    'optional_price' => $bookingDetails->optional01_price,
                    'optional_total' => $bookingDetails->optional01_total
                    ]
                );
            } else {
                OptionalArrangementDetails::create([
                    'booking_id' => $bookingId
                ]);
            }

            if ($bookingDetails->optional02_desc) {
                // OptionalArrangementDetails::create([
                //     'booking_id' => $request->bookingid,
                //     'optional_desc' => $bookingDetails->optional02_desc,
                //     'optional_sst' => $bookingDetails->optional02_GST,
                //     'optional_code' => $bookingDetails->optional02_bill_to,
                //     'optional_qty' => $bookingDetails->optional02_pax,
                //     'optional_price' => $bookingDetails->optional02_price,
                //     'optional_total' => $bookingDetails->optional02_total
                // ]);

                OptionalArrangementDetails::updateOrCreate(
                    ['optional_desc' => $bookingDetails->optional01_desc,
                     'booking_id' => $bookingId
                    ],
                    ['booking_id' => $request->bookingid,
                    'optional_desc' => $bookingDetails->optional02_desc,
                    'optional_sst' => $bookingDetails->optional02_GST,
                    'optional_code' => $bookingDetails->optional02_bill_to,
                    'optional_qty' => $bookingDetails->optional02_pax,
                    'optional_price' => $bookingDetails->optional02_price,
                    'optional_total' => $bookingDetails->optional02_total
                    ]
                );
            } else {
                OptionalArrangementDetails::create([
                    'booking_id' => $bookingId
                ]);
            }
            if ($bookingDetails->optional03_desc) {
                // OptionalArrangementDetails::create([
                //     'booking_id' => $request->bookingid,
                //     'optional_desc' => $bookingDetails->optional03_desc,
                //     'optional_sst' => $bookingDetails->optional03_GST,
                //     'optional_code' => $bookingDetails->optional03_bill_to,
                //     'optional_qty' => $bookingDetails->optional03_pax,
                //     'optional_price' => $bookingDetails->optional03_price,
                //     'optional_total' => $bookingDetails->optional03_total
                // ]);

                OptionalArrangementDetails::updateOrCreate(
                    ['optional_desc' => $bookingDetails->optional01_desc,
                     'booking_id' => $bookingId
                    ],
                    ['booking_id' => $request->bookingid,
                    'optional_desc' => $bookingDetails->optional03_desc,
                    'optional_sst' => $bookingDetails->optional03_GST,
                    'optional_code' => $bookingDetails->optional03_bill_to,
                    'optional_qty' => $bookingDetails->optional03_pax,
                    'optional_price' => $bookingDetails->optional03_price,
                    'optional_total' => $bookingDetails->optional03_total
                    ]
                );
            } else {
                OptionalArrangementDetails::create([
                    'booking_id' => $bookingId
                ]);
            }
            if ($bookingDetails->optional04_desc) {
                // OptionalArrangementDetails::create([
                //     'booking_id' => $request->bookingid,
                //     'optional_desc' => $bookingDetails->optional04_desc,
                //     'optional_sst' => $bookingDetails->optional04_GST,
                //     'optional_code' => $bookingDetails->optional04_bill_to,
                //     'optional_qty' => $bookingDetails->optional04_pax,
                //     'optional_price' => $bookingDetails->optional04_price,
                //     'optional_total' => $bookingDetails->optional04_total
                // ]);

                OptionalArrangementDetails::updateOrCreate(
                    ['optional_desc' => $bookingDetails->optional01_desc,
                     'booking_id' => $bookingId
                    ],
                    ['booking_id' => $request->bookingid,
                    'optional_desc' => $bookingDetails->optional04_desc,
                    'optional_sst' => $bookingDetails->optional04_GST,
                    'optional_code' => $bookingDetails->optional04_bill_to,
                    'optional_qty' => $bookingDetails->optional04_pax,
                    'optional_price' => $bookingDetails->optional04_price,
                    'optional_total' => $bookingDetails->optional04_total
                    ]
                );
            } else {
                OptionalArrangementDetails::create([
                    'booking_id' => $bookingId
                ]);
            }
            if ($bookingDetails->optional05_desc) {
                // OptionalArrangementDetails::create([
                //     'booking_id' => $request->bookingid,
                //     'optional_desc' => $bookingDetails->optional05_desc,
                //     'optional_sst' => $bookingDetails->optional05_GST,
                //     'optional_code' => $bookingDetails->optional05_bill_to,
                //     'optional_qty' => $bookingDetails->optional05_pax,
                //     'optional_price' => $bookingDetails->optional05_price,
                //     'optional_total' => $bookingDetails->optional05_total
                // ]);

                OptionalArrangementDetails::updateOrCreate(
                    ['optional_desc' => $bookingDetails->optional01_desc,
                     'booking_id' => $bookingId
                    ],
                    ['booking_id' => $request->bookingid,
                    'optional_desc' => $bookingDetails->optional05_desc,
                    'optional_sst' => $bookingDetails->optional05_GST,
                    'optional_code' => $bookingDetails->optional05_bill_to,
                    'optional_qty' => $bookingDetails->optional05_pax,
                    'optional_price' => $bookingDetails->optional05_price,
                    'optional_total' => $bookingDetails->optional05_total
                    ]
                );
            } else {
                OptionalArrangementDetails::create([
                    'booking_id' => $bookingId
                ]);
            }

        }
        // return redirect()->route('form2', ['bookingId' => $bookingId])
        //     ->with('success', 'Booking has been successfully filled and booking ID is ' . $bookingId);
        if ($request->amendid) {
            return redirect('form2/' . $bookingId . '/' . $request->amendid);
        } else {
            return redirect('form2/' . $bookingId . '/' . 0);
        }
        
    }

    public function leads()
    {
        // Retrieve all leads from the database
        $leads = Leads::all();
        // Pass the leads to the Blade view
        return view('form', ['leads' => $leads]);
    }

    public function getBookingData($bookingId, $amendID)
    {   
        // Fetch the booking data based on the provided booking ID
        info($amendID);
        $booking = Bookings::where('booking_id', $bookingId)->where('amend_id', $amendID)->first();
        info($booking);
        $amendBooking = Bookings::query()
        ->where('booking_id', $bookingId)
        ->where('amend_id', '>', 0)
        ->get();

        $password = NamelistUser::where('booking_id', $bookingId)->value('password');

        if ($booking) {
            return response()->json([
                'success' => true,
                'password'=> $password,
                'booking' => $booking,
                'amendBooking' => $amendBooking
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found.'
            ]);
        }
        
    }

    public function getBookingAmendData(Request $request, $bookingId) {
        // Fetch the booking data based on the provided booking ID
        // $booking = Bookings::where('booking_id', $bookingId)->first();
        $amendID = $request->amendID;
        // if ($amendID == 0) {
        //     $booking = Bookings::query()
        //     ->where('booking_id', $bookingId)
        //     ->first();

        //     $amendBooking = BookingsAmend::query()
        //     ->where('booking_id', $bookingId)
        //     ->get();
        // } else {
        //     $booking = BookingsAmend::query()
        //     ->where('booking_id', $bookingId)
        //     ->where('amend_id', $amendID)
        //     ->first();

        //     $amendBooking = BookingsAmend::query()
        //     ->where('booking_id', $bookingId)
        //     ->get();
        // }
        $booking = Bookings::query()
        ->where('booking_id', $bookingId)
        ->where('amend_id', $amendID)
        ->first();

        $amendBooking = Bookings::query()
        ->where('booking_id', $bookingId)
        ->where('amend_id', '>', 0)
        ->get();

        $password = NamelistUser::where('booking_id', $bookingId)->value('password');

        if ($booking) {
            return response()->json([
                'success' => true,
                'password'=> $password,
                'booking' => $booking,
                'amendBooking' => $amendBooking
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found.'
            ]);
        }
    }

    public function amendBooking(Request $request, $bookingId) {

        $bookingDetails = Bookings::query()
        ->where('booking_id', $bookingId)
        ->where('amend_id', $request->amendid)
        ->where('cancel', 0)
        ->first()
        ->toArray();

        $bookingDetails['amend_id'] = Bookings::where('booking_id', $bookingId)->max('amend_id') + 1;

        // BookingsAmend::insert($bookingDetails);
        Bookings::insert($bookingDetails);

        Bookings::query()
        ->where('amend_id', $request->amendid)
        ->where('booking_id', $bookingId)
        ->update([
            'cancel'    =>  1
        ]);

        $latestBooking = Bookings::query()
            ->where('booking_id', $bookingId)
            ->where('cancel', 0)
            ->first();

        $date = Carbon::now()->format('Y-m-d'); 

        if ($latestBooking) {
            $latestBooking->where('cancel', 0)
            ->update([
                'date' => $date,
            ]);
        }

        return response()->json([
            'success' => true, // Add a success flag
            'message' => 'Dates updated successfully.'
        ], 200); // Ensure a 200 response
    }

    public function form2($bookingId, $amendId) {
        // Use the bookingId for logic or pass it to the view
        return view('form2', compact('bookingId', 'amendId'));
    }

    public function booking($bookingId, $amendId)
    {
        $pickups = PickupDetails::where('booking_id', $bookingId)->get();
        $total_pickup = number_format($pickups->sum('total_pickup_rate'), 2);

        $dropoffs = DropoffDetails::where('booking_id', $bookingId)->get();
        $total_dropoff = number_format($dropoffs->sum('total_dropoff_rate'), 2);

        $optionalArrangements = OptionalArrangementDetails::where('booking_id', $bookingId)->get();

        $pickupOptions = Pickup::pluck('pickup_name');
        $dropoffOptions = Dropoff::pluck('dropoff_name');
        $optionalOptions = OptionalArrangement::pluck('optional_name');

        // Fetch the booking data based on the provided booking ID
        // if ($amendId == 0) {
        //     $bookings = Bookings::where('booking_id', $bookingId)->first();
        // } else {
        //     $bookings = BookingsAmend::where('booking_id', $bookingId)->where('amend_id', $amendId)->first();
        // }
        $bookings = Bookings::where('booking_id', $bookingId)->where('amend_id', $amendId)->first();

        $optionalbooking_total = $bookings->optional01_total + $bookings->optional02_total + $bookings->optional03_total + $bookings->optional04_total + $bookings->optional05_total;
        $optionalArrangementstotal = $optionalArrangements->sum('optional_total');
        $total_optional = number_format($optionalbooking_total + $optionalArrangementstotal, 2);

        // $check_in = Carbon::createFromFormat('d/m/Y', $bookings->check_in);
        // $check_out = Carbon::createFromFormat('d/m/Y',  $bookings->check_in);
        $check_in = Carbon::parse( $bookings->check_in); // Start date
        $check_out = Carbon::parse( $bookings->check_out);   // End date

        $days = (int)$check_in->diffInDays($check_out) + 1;
        $nights = (int)$check_in->diffInDays($check_out); 

        $total_pickup = $pickups->sum('total_pickup_rate');

        $total_pickup = number_format($total_pickup + $bookings->pickup01_total + $bookings->pickup02_total + $bookings->pickup03_total, 2);

        $total_dropoff = $dropoffs->sum('total_dropoff_rate');

        $total_dropoff = number_format($total_dropoff + $bookings->dropoff01_total + $bookings->dropoff02_total + $bookings->dropoff03_total, 2);

        $package_total = number_format($bookings->package_total, 2);
        $land_transfer_total = number_format($total_pickup + $total_dropoff, 2);
        $optional_total = $total_optional;
        $total_summary = number_format($bookings->package_total + $total_pickup + $total_dropoff + $optionalArrangements->sum('optional_total'), 2);

        $rates = DB::table('calendar as c')
        ->select('r.*')
        ->join('rates as r', 'c.price_ID', '=', 'r.price_ID')
        ->where('c.dates', $bookings->check_in)
        ->select('c.*', 'r.*')
        ->first();

        $extra_charge_adult = 0;
        $extra_charge_child = 0;
        $holiday_rates = 0;
        if ($days > 3) {
            $date_after_two_night = $check_in->addDays(2);
            $previousDate = $check_out->subDay();
            $add_rates = DB::table('calendar as c')
            ->select('r.*')
            ->join('rates as r', 'c.price_ID', '=', 'r.price_ID')
            ->whereBetween('c.dates', [$date_after_two_night, $previousDate])
            ->select('c.*', 'r.*')
            ->get();

            $holiday_rates = 0;
            foreach ($add_rates as $row) {
                if ($row->school_hol == 1) {
                    $holiday_rates += 25;
                }
            }

            $extra_charge_adult = $add_rates->sum('add_a');
            $extra_charge_child = $add_rates->sum('add_c');

        }

        $double_adult_rates = ($rates?->double_a ?? 0) + $extra_charge_adult + $holiday_rates;
        $double_adult_mat_rates = ($rates?->double_m_a ?? 0) + $extra_charge_adult + $holiday_rates;
        $double_child_rates = ($rates?->double_c ?? 0) + $extra_charge_child + $holiday_rates;
        $double_child_mat_rates = ($rates?->double_m_c ?? 0) + $extra_charge_child + $holiday_rates;
        $double_toddler_rates = 100;

        $triple_adult_rates = ($rates?->triple_a ?? 0) + $extra_charge_adult + $holiday_rates;
        $triple_child_rates = ($rates?->triple_c ?? 0) + $extra_charge_child + $holiday_rates;
        $triple_toddler_rates = 100;

        $quad_adult_rates = ($rates?->quad_a ?? 0) + $extra_charge_adult + $holiday_rates;
        $quad_adult_mat_rates = ($rates?->quad_m_a ?? 0) + $extra_charge_adult + $holiday_rates;
        $quad_child_rates = ($rates?->quad_c ?? 0) + $extra_charge_child + $holiday_rates;
        $quad_child_mat_rates = ($rates?->quad_m_c ?? 0) + $extra_charge_child + $holiday_rates;
        $quad_toddler_rates = 100;

        // seaview
        $base_price = 100;
        $additional_day_price = 50; // Price for each additional day
        $extra_days = $days - 3; // Number of additional days

        $add_seaview = $base_price + ($extra_days * $additional_day_price);
        $sea_double_adult_rates = ($rates?->double_a ?? 0) + $extra_charge_adult + $add_seaview + $holiday_rates;
        $sea_double_adult_mat_rates = ($rates?->double_m_a ?? 0) + $extra_charge_adult + $add_seaview + $holiday_rates;
        $sea_double_child_rates = ($rates?->double_c ?? 0) + $extra_charge_child + $add_seaview + $holiday_rates;
        $sea_double_child_mat_rates = ($rates?->double_m_c ?? 0) + $extra_charge_child + $add_seaview + $holiday_rates;
        $sea_double_toddler_rates = 100;

        $sea_triple_adult_rates = ($rates?->triple_a ?? 0) + $extra_charge_adult + $add_seaview + $holiday_rates;
        $sea_triple_child_rates = ($rates?->triple_c ?? 0) + $extra_charge_child + $add_seaview + $holiday_rates;
        $sea_triple_toddler_rates = 100;

        $sea_quad_adult_rates = ($rates?->quad_a ?? 0) + $extra_charge_adult + $add_seaview + $holiday_rates;
        $sea_quad_adult_mat_rates = ($rates?->quad_m_a ?? 0) + $extra_charge_adult + $add_seaview + $holiday_rates;
        $sea_quad_child_rates = ($rates?->quad_c ?? 0) + $extra_charge_child + $add_seaview + $holiday_rates;
        $sea_quad_child_mat_rates = ($rates?->quad_m_c ?? 0) + $extra_charge_child + $add_seaview + $holiday_rates;
        $sea_quad_toddler_rates = 100;

        $sum_double = ($bookings->d_adult_pax + $bookings->d_child_pax + $bookings->d_toddler_pax) / 2;
        $sum_triple = ($bookings->t_adult_pax + $bookings->t_child_pax + $bookings->t_toddler_pax) / 3;
        $sum_quad   = ($bookings->q_adult_pax + $bookings->q_child_pax + $bookings->q_toddler_pax) / 4;

        $sea_sum_double = ($bookings->deluxe_d_adult_pax + $bookings->deluxe_d_child_pax + $bookings->deluxe_d_toddler_pax) / 2;
        $sea_sum_triple = ($bookings->deluxe_t_adult_pax + $bookings->deluxe_t_child_pax + $bookings->deluxe_t_toddler_pax) / 3;
        $sea_sum_quad   = ($bookings->deluxe_q_adult_pax + $bookings->deluxe_q_child_pax + $bookings->deluxe_q_toddler_pax) / 4;

        $sum_double_ceil = ceil($sum_double);
        $sum_triple_ceil = ceil($sum_triple);
        $sum_quad_ceil   = ceil($sum_quad);

        $sea_sum_double_ceil = ceil($sea_sum_double);
        $sea_sum_triple_ceil = ceil($sea_sum_triple);
        $sea_sum_quad_ceil   = ceil($sea_sum_quad);
        
        $sum_double_mat = $bookings->d_adult_m_pax + $bookings->d_child_m_pax;
        $sum_quad_mat = $bookings->q_adult_m_pax + $bookings->q_child_m_pax;

        $sea_sum_double_mat = $bookings->deluxe_d_adult_m_pax + $bookings->deluxe_d_child_m_pax;
        $sea_sum_quad_mat = $bookings->deluxe_q_adult_m_pax + $bookings->deluxe_q_child_m_pax;

        $sum_rooms = [
            'sum_double'    =>  $sum_double,
            'sum_triple'    =>  $sum_triple,
            'sum_quad'      =>  $sum_quad,

            'sum_double_ceil'    =>  $sum_double_ceil,
            'sum_triple_ceil'    =>  $sum_triple_ceil,
            'sum_quad_ceil'      =>  $sum_quad_ceil,
            'sum_double_mat' => $sum_double_mat,
            'sum_quad_mat'   => $sum_quad_mat,

            'sea_sum_double'    =>  $sea_sum_double,
            'sea_sum_triple'    =>  $sea_sum_triple,
            'sea_sum_quad'      =>  $sea_sum_quad,

            'sea_sum_double_ceil'    =>  $sea_sum_double_ceil,
            'sea_sum_triple_ceil'    =>  $sea_sum_triple_ceil,
            'sea_sum_quad_ceil'      =>  $sea_sum_quad_ceil,
            'sea_sum_double_mat' => $sea_sum_double_mat,
            'sea_sum_quad_mat'   => $sea_sum_quad_mat
        ];

        $room_rates = [
            'double_adult'      =>  $double_adult_rates,
            'double_adult_mat'  =>  $double_adult_mat_rates,
            'double_child'      =>  $double_child_rates,
            'double_child_mat'  =>  $double_child_mat_rates,
            'double_toddler'    =>  $double_toddler_rates, 
            
            'triple_adult'      =>  $triple_adult_rates,
            'triple_child'      =>  $triple_child_rates,
            'triple_toddler'    =>  $triple_toddler_rates,  

            'quad_adult'        =>  $quad_adult_rates,
            'quad_adult_mat'    =>  $quad_adult_mat_rates,
            'quad_child'        =>  $quad_child_rates,
            'quad_child_mat'    =>  $quad_child_mat_rates,
            'quad_toddler'      =>  $quad_toddler_rates,
            
            // seaview
            'sea_double_adult'      =>  $sea_double_adult_rates,
            'sea_double_adult_mat'  =>  $sea_double_adult_mat_rates,
            'sea_double_child'      =>  $sea_double_child_rates,
            'sea_double_child_mat'  =>  $sea_double_child_mat_rates,
            'sea_double_toddler'    =>  $sea_double_toddler_rates, 
            
            'sea_triple_adult'      =>  $sea_triple_adult_rates,
            'sea_triple_child'      =>  $sea_triple_child_rates,
            'sea_triple_toddler'    =>  $sea_triple_toddler_rates,  

            'sea_quad_adult'        =>  $sea_quad_adult_rates,
            'sea_quad_adult_mat'    =>  $sea_quad_adult_mat_rates,
            'sea_quad_child'        =>  $sea_quad_child_rates,
            'sea_quad_child_mat'    =>  $sea_quad_child_mat_rates,
            'sea_quad_toddler'      =>  $sea_quad_toddler_rates,   
        ];
        return view('form2', compact('bookings', 'days', 'nights', 'room_rates', 'sum_rooms', 'package_total', 'land_transfer_total', 'optional_total', 'total_summary', 'amendId'));

    }

    public function changeValue(Request $request, $bookingId) {   
        $check_in = Carbon::parse( $request->check_in); // Start date
        $check_out = Carbon::parse( $request->check_out);   // End date

        $days = $check_in->diffInDays($check_out) + 1; // Including both start and end date
        $nights = $check_in->diffInDays($check_out); 
        
        $days = $days;

        if ($request->type == 'date') {

            $extra_charge_adult = 0;
            $extra_charge_child = 0;

            $rates = DB::table('calendar as c')
            ->select('r.*')
            ->join('rates as r', 'c.price_ID', '=', 'r.price_ID')
            ->where('c.dates', $check_in)
            ->select('c.*', 'r.*')
            ->first();

            $holiday_rates = 0;

            if ($days > 3) {
                $date_after_two_night = $check_in->addDays(2);
                $previousDate = $check_out->subDay();

                $add_rates = DB::table('calendar as c')
                ->select('r.*')
                ->join('rates as r', 'c.price_ID', '=', 'r.price_ID')
                ->whereBetween('c.dates', [$date_after_two_night, $previousDate])
                ->select('c.*', 'r.*')
                ->get();

                $holiday_rates = 0;
                foreach ($add_rates as $row) {
                    if ($row->school_hol == 1) {
                        $holiday_rates += 25;
                    }
                }

                $extra_charge_adult = $add_rates->sum('add_a');
                $extra_charge_child = $add_rates->sum('add_c');

            }

            $double_adult_rates = $rates->double_a + $extra_charge_adult + $holiday_rates;
            $double_adult_mat_rates = $rates->double_m_a + $extra_charge_adult + $holiday_rates;
            $double_child_rates = $rates->double_c + $extra_charge_child + $holiday_rates;
            $double_child_mat_rates = $rates->double_m_c +  $extra_charge_child + $holiday_rates;
            $double_toddler_rates = 100;

            $triple_adult_rates = $rates->triple_a + $extra_charge_adult + $holiday_rates;
            $triple_child_rates = $rates->triple_c + $extra_charge_child + $holiday_rates;
            $triple_toddler_rates = 100;

            $quad_adult_rates = $rates->quad_a + $extra_charge_adult + $holiday_rates;
            $quad_adult_mat_rates = $rates->quad_m_a + $extra_charge_adult + $holiday_rates;
            $quad_child_rates =  $rates->quad_c + $extra_charge_child + $holiday_rates;
            $quad_child_mat_rates = $rates->quad_m_c + $extra_charge_child + $holiday_rates;
            $quad_toddler_rates = 100;

            $base_price = 100;
            $additional_day_price = 50; // Price for each additional day
            $extra_days = $days - 3; // Number of additional days

            $add_seaview = $base_price + ($extra_days * $additional_day_price);

            $sea_double_adult_rates = $rates->double_a + $extra_charge_adult + $add_seaview + $holiday_rates;
            $sea_double_adult_mat_rates = $rates->double_m_a + $extra_charge_adult + $add_seaview + $holiday_rates;
            $sea_double_child_rates = $rates->double_c + $extra_charge_child + $add_seaview + $holiday_rates;
            $sea_double_child_mat_rates = $rates->double_m_c + $extra_charge_child + $add_seaview + $holiday_rates;
            $sea_double_toddler_rates = 100;

            $sea_triple_adult_rates = $rates->triple_a + $extra_charge_adult + $add_seaview + $holiday_rates;
            $sea_triple_child_rates = $rates->triple_c + $extra_charge_child + $add_seaview + $holiday_rates;
            $sea_triple_toddler_rates = 100;

            $sea_quad_adult_rates = $rates->quad_a + $extra_charge_adult + $add_seaview + $holiday_rates;
            $sea_quad_adult_mat_rates = $rates->quad_m_a + $extra_charge_adult + $add_seaview + $holiday_rates;
            $sea_quad_child_rates = $rates->quad_c + $extra_charge_child + $add_seaview + $holiday_rates;
            $sea_quad_child_mat_rates = $rates->quad_m_c + $extra_charge_child + $add_seaview + $holiday_rates;
            $sea_quad_toddler_rates = 100;

            //update rates into bookings table
            // if ($request->amendid == 0) {
                Bookings::query()
                ->where('booking_id', $bookingId)
                ->where('amend_id', $request->amendid)
                ->update([
                    'check_in'  =>  $request->check_in,
                    'check_out' =>  $request->check_out,
                    'd_adult_price' =>  $double_adult_rates,
                    'd_adult_m_price' =>    $double_adult_mat_rates,
                    'd_child_price' =>  $double_child_rates,
                    'd_child_m_price' =>    $double_child_mat_rates,
                    'd_toddler_price' =>    $double_toddler_rates,
                    't_adult_price' =>  $triple_adult_rates,
                    't_child_price' =>  $triple_child_rates,
                    't_toddler_price' =>    $triple_toddler_rates,
                    'q_adult_price' =>  $quad_adult_rates,
                    'q_adult_m_price' =>    $quad_adult_mat_rates,
                    'q_child_price' =>  $quad_child_rates,
                    'q_child_m_price' =>    $quad_child_mat_rates,
                    'q_toddler_price' =>    $quad_toddler_rates,
                    'deluxe_d_adult_price' =>   $sea_double_adult_rates,
                    'deluxe_d_adult_m_price' => $sea_double_adult_mat_rates,
                    'deluxe_d_child_price' =>   $sea_double_child_rates,
                    'deluxe_d_child_m_price' => $sea_double_child_mat_rates,
                    'deluxe_d_toddler_price' => $sea_double_toddler_rates,
                    'deluxe_t_adult_price' =>   $sea_triple_adult_rates,
                    'deluxe_t_child_price' =>   $sea_triple_child_rates,
                    'deluxe_t_toddler_price' => $sea_triple_toddler_rates,
                    'deluxe_q_adult_price' =>   $sea_quad_adult_rates,
                    'deluxe_q_adult_m_price' => $sea_quad_adult_mat_rates,
                    'deluxe_q_child_price' =>   $sea_quad_child_rates,
                    'deluxe_q_child_m_price' => $sea_quad_child_mat_rates,
                    'deluxe_q_toddler_price' => $sea_quad_toddler_rates,
                ]);

                $booking_details = Bookings::query()
                ->where('booking_id', $bookingId)
                ->first();
            // } else {
            //     BookingsAmend::query()
            //     ->where('booking_id', $bookingId)
            //     ->where('amend_id', $request->amendid)
            //     ->update([
            //         'check_in'  =>  $request->check_in,
            //         'check_out' =>  $request->check_out,
            //         'd_adult_price' =>  $double_adult_rates,
            //         'd_adult_m_price' =>    $double_adult_mat_rates,
            //         'd_child_price' =>  $double_child_rates,
            //         'd_child_m_price' =>    $double_child_mat_rates,
            //         'd_toddler_price' =>    $double_toddler_rates,
            //         't_adult_price' =>  $triple_adult_rates,
            //         't_child_price' =>  $triple_child_rates,
            //         't_toddler_price' =>    $triple_toddler_rates,
            //         'q_adult_price' =>  $quad_adult_rates,
            //         'q_adult_m_price' =>    $quad_adult_mat_rates,
            //         'q_child_price' =>  $quad_child_rates,
            //         'q_child_m_price' =>    $quad_child_mat_rates,
            //         'q_toddler_price' =>    $quad_toddler_rates,
            //         'deluxe_d_adult_price' =>   $sea_double_adult_rates,
            //         'deluxe_d_adult_m_price' => $sea_double_adult_mat_rates,
            //         'deluxe_d_child_price' =>   $sea_double_child_rates,
            //         'deluxe_d_child_m_price' => $sea_double_child_mat_rates,
            //         'deluxe_d_toddler_price' => $sea_double_toddler_rates,
            //         'deluxe_t_adult_price' =>   $sea_triple_adult_rates,
            //         'deluxe_t_child_price' =>   $sea_triple_child_rates,
            //         'deluxe_t_toddler_price' => $sea_triple_toddler_rates,
            //         'deluxe_q_adult_price' =>   $sea_quad_adult_rates,
            //         'deluxe_q_adult_m_price' => $sea_quad_adult_mat_rates,
            //         'deluxe_q_child_price' =>   $sea_quad_child_rates,
            //         'deluxe_q_child_m_price' => $sea_quad_child_mat_rates,
            //         'deluxe_q_toddler_price' => $sea_quad_toddler_rates,
            //     ]);

            //     $booking_details = BookingsAmend::query()
            //     ->where('booking_id', $bookingId)
            //     ->where('amend_id', $request->amendid)
            //     ->first();
            // }

            return response()->json([
                'message' => 'Dates updated successfully.',
                'days' => $days,
                'nights' => $nights,
            ]);
        }

        if ($request->type == 'change') {
            $double_price = $request->pax['double'];
            $double_pax = $request->pax['pax_count']['double'];

            $double_adult_pax = $double_pax['adult'] * $double_price['adult'];
            $double_adult_mat_pax = $double_pax['adult_mat'] * $double_price['adult_mat'];
            $double_child_pax = $double_pax['child'] * $double_price['child'];
            $double_child_mat_pax = $double_pax['child_mat'] * $double_price['child_mat'];
            $double_toddler_pax = $double_pax['toddler'] * $double_price['toddler'];
            $total_double_rates = $double_adult_pax + $double_adult_mat_pax + $double_child_pax + $double_child_mat_pax + $double_toddler_pax;
            $sum_double_pax = ($double_pax['adult'] + $double_pax['child']) / 2; //+  $request->pax['double_toddler_pax'];
            $sum_double_mat_pax = $double_pax['adult_mat'] + $double_pax['child_mat'];

            $triple_price = $request->pax['triple'];
            $triple_pax = $request->pax['pax_count']['triple'];

            $triple_adult_pax = $triple_pax['adult'] * $triple_price['adult'];
            $triple_child_pax = $triple_pax['child'] * $triple_price['child'];
            $triple_toddler_pax = $triple_pax['toddler'] * $triple_price['toddler'];
            $total_triple_rates = $triple_adult_pax + $triple_child_pax + $triple_toddler_pax;
            $sum_triple_pax = ($triple_pax['adult'] + $triple_pax['toddler']) / 3; // + $request->pax['triple_toddler_pax'];

            $quad_price = $request->pax['quad'];
            $quad_pax = $request->pax['pax_count']['quad'];

            $quad_adult_pax = $quad_pax['adult'] * $quad_price['adult'];
            $quad_adult_mat_pax = $quad_pax['adult_mat'] * $quad_price['adult_mat'];
            $quad_child_pax = $quad_pax['child'] * $quad_price['child'];
            $quad_child_mat_pax = $quad_pax['child_mat'] * $quad_price['child_mat'];
            $quad_toddler_pax = $quad_pax['toddler'] * $quad_price['toddler'];
            $total_quad_rates = $quad_adult_pax + $quad_adult_mat_pax + $quad_child_pax + $quad_child_mat_pax + $quad_toddler_pax;
            $sum_quad_pax = ($quad_pax['adult'] +  $quad_pax['child']) / 4; // + $request->pax['quad_toddler_pax'];
            $sum_quad_mat_pax = $quad_pax['adult_mat'] + $quad_pax['child_mat'];

            //seaview.
            $sea_double_price = $request->pax['seaview']['double'];
            $sea_double_pax = $request->pax['seaview_pax_count']['double'];

            $sea_double_adult_pax = $sea_double_price['adult'] * $sea_double_pax['adult'];
            $sea_double_adult_mat_pax = $sea_double_price['adult_mat'] * $sea_double_pax['adult_mat'];
            $sea_double_child_pax = $sea_double_price['child'] * $sea_double_pax['child'];
            $sea_double_child_mat_pax = $sea_double_price['child_mat'] * $sea_double_pax['child_mat'];
            $sea_double_toddler_pax = $sea_double_price['toddler'] * $sea_double_pax['toddler'];
            $sea_total_double_rates = $sea_double_adult_pax + $sea_double_adult_mat_pax + $sea_double_child_pax + $sea_double_child_mat_pax + $sea_double_toddler_pax;
            $sea_sum_double_pax = ($sea_double_pax['adult'] +  $sea_double_pax['child']) / 2; // +  $request->pax['sea_double_toddler_pax'];
            $sea_sum_double_mat_pax = $sea_double_pax['adult_mat'] + $sea_double_pax['child_mat'];

            $sea_triple_price = $request->pax['seaview']['triple'];
            $sea_triple_pax = $request->pax['seaview_pax_count']['triple'];

            $sea_triple_adult_pax = $sea_triple_price['adult'] * $sea_triple_pax['adult'];
            $sea_triple_child_pax = $sea_triple_price['child'] * $sea_triple_pax['child'];
            $sea_triple_toddler_pax = $sea_triple_price['toddler'] * $sea_triple_pax['toddler'];
            $sea_total_triple_rates = $sea_triple_adult_pax + $sea_triple_child_pax + $sea_triple_toddler_pax;
            $sea_sum_triple_pax = ($sea_triple_pax['adult'] + $sea_triple_pax['child']) / 3;  //+ $request->pax['sea_triple_toddler_pax'];

            $sea_quad_price = $request->pax['seaview']['quad'];
            $sea_quad_pax = $request->pax['seaview_pax_count']['quad'];

            $sea_quad_adult_pax = $sea_quad_price['adult'] * $sea_quad_pax['adult'];
            $sea_quad_adult_mat_pax = $sea_quad_price['adult_mat'] * $sea_quad_pax['adult_mat'];
            $sea_quad_child_pax = $sea_quad_price['child'] * $sea_quad_pax['child'];
            $sea_quad_child_mat_pax = $sea_quad_price['child_mat'] * $sea_quad_pax['child_mat'];
            $sea_quad_toddler_pax = $sea_quad_price['toddler'] * $sea_quad_pax['toddler'];
            $sea_total_quad_rates = $sea_quad_adult_pax + $sea_quad_adult_mat_pax + $sea_quad_child_pax + $sea_quad_child_mat_pax + $sea_quad_toddler_pax;
            $sea_sum_quad_pax = ($sea_quad_pax['adult'] +  $sea_quad_pax['child']) / 4; // +  $request->pax['sea_quad_toddler_pax'];
            $sea_sum_quad_mat_pax = $sea_quad_pax['adult_mat'] + $sea_quad_pax['child_mat'];

            $total_package = $total_double_rates + $total_triple_rates + $total_quad_rates + $sea_total_double_rates + $sea_total_triple_rates + $sea_total_quad_rates;

            return response()->json([
                'message' => 'Dates updated successfully.',
                'days' => $days,
                'nights' => $nights,
                'type'  =>  'change',
                'total_package' => $total_package,
                'sum_pax'   => [    
                    'sum_double_pax'    => $sum_double_pax,
                    'sum_triple_pax'    => $sum_triple_pax,
                    'sum_quad_pax'      => $sum_quad_pax,
                    'sea_sum_double_pax'=> $sea_sum_double_pax,
                    'sea_sum_triple_pax'=> $sea_sum_triple_pax,
                    'sea_sum_quad_pax'  => $sea_sum_quad_pax,
                ],
                'sum_mat_pax'   => [
                    'sum_double_mat_pax' => $sum_double_mat_pax,
                    'sum_quad_mat_pax' => $sum_quad_mat_pax,
                    'sea_sum_double_mat_pax' => $sea_sum_double_mat_pax,
                    'sea_sum_quad_mat_pax' => $sea_sum_quad_mat_pax
                ],
                'pax'   =>  [
                    'double_adult_pax' => $double_pax['adult'],
                    'double_child_pax' =>  $double_pax['child'],
                    'double_toodler_pax' => $double_pax['toddler'],
                    'triple_adult_pax' => $triple_pax['adult'],
                    'triple_child_pax' => $triple_pax['child'],
                    'triple_toddler_pax' => $triple_pax['toddler'],
                    'quad_adult_pax' => $quad_pax['adult'],
                    'quad_child_pax' => $quad_pax['child'],
                    'quad_toddler_pax' => $quad_pax['toddler'],

                    'sea_double_adult_pax' => $sea_double_price['adult'],
                    'sea_double_child_pax' => $sea_double_price['child'],
                    'sea_double_toddler_pax' => $sea_double_price['toddler'],
                    'sea_triple_adult_pax' => $sea_triple_price['adult'],
                    'sea_triple_child_pax' => $sea_triple_price['child'],
                    'sea_triple_toddler_pax' => $sea_triple_price['toddler'],
                    'sea_quad_adult_pax' => $sea_quad_price['adult'],
                    'sea_quad_child_pax' => $sea_quad_price['child'],
                    'sea_quad_toddler_pax' => $sea_quad_price['toddler']
                ]
            ]);
    
        }
    }

    public function saveValue(Request $request, $bookingId) {
        $paxRoom = $request->paxRoom;
        $pax = $request->pax;

        $updateData = [
            'package_total'  => $request->total_package,
            'check_in'       => $request->check_in,
            'check_out'      => $request->check_out,
            'pax_adult'      => $request->pax_adult ?? 0,
            'pax_child'      => $request->pax_child ?? 0,
            'pax_toddler'    => $request->pax_toddler ?? 0,
            'pax_foc_tl'     => $request->pax_foc_tl ?? 0,
            'room_double'    => $paxRoom['double'],
            'room_triple'    => $paxRoom['triple'],
            'room_quad'      => $paxRoom['quad'],
            'deluxe_double'  => $paxRoom['sea_double'],
            'deluxe_triple'  => $paxRoom['sea_triple'],
            'deluxe_quad'  => $paxRoom['sea_quad'],

        ];

        
        $fields = [
            'double_adult_pax' => 'd_adult_pax',
            'double_adult_price' => 'd_adult_price',
            'double_adult_mat_pax' => 'd_adult_m_pax',
            'double_adult_mat_price' => 'd_adult_m_price',

            'double_child_pax' => 'd_child_pax',
            'double_child_price' => 'd_child_price',
            'double_child_mat_pax' => 'd_child_m_pax',
            'double_child_mat_price' => 'd_child_m_price',

            'double_toddler_pax' => 'd_toddler_pax',
            'double_toddler_price' => 'd_toddler_price',

            'triple_adult_pax' => 't_adult_pax',
            'triple_adult_price' => 't_adult_price',

            'triple_child_pax' => 't_child_pax',
            'triple_child_price' => 't_child_price',

            'triple_toddler_pax' => 't_toddler_pax',
            'triple_toddler_price' => 't_toddler_price',

            'quad_adult_pax' => 'q_adult_pax',
            'quad_adult_price' => 'q_adult_price',
            'quad_adult_mat_pax' => 'q_adult_m_pax',
            'quad_adult_mat_price' => 'q_adult_m_price',

            'quad_child_pax' => 'q_child_pax',
            'quad_child_price' => 'q_child_price',
            'quad_child_mat_pax' => 'q_child_m_pax',
            'quad_child_mat_price' => 'q_child_m_price',

            'quad_toddler_pax' => 'q_toddler_pax',
            'quad_toddler_price' => 'q_toddler_price',

            'sea_double_adult_pax' => 'deluxe_d_adult_pax',
            'sea_double_adult_mat_pax' => 'deluxe_d_adult_m_pax',
            'sea_double_child_pax' => 'deluxe_d_child_pax',
            'sea_double_child_mat_pax' => 'deluxe_d_child_m_pax',
            'sea_double_toddler_pax' => 'deluxe_d_toddler_pax',
            'sea_triple_adult_pax' => 'deluxe_t_adult_pax',
            'sea_triple_child_pax' => 'deluxe_t_child_pax',
            'sea_triple_toddler_pax' => 'deluxe_t_toddler_pax',
            'sea_quad_adult_pax' => 'deluxe_q_adult_pax',
            'sea_quad_child_pax' => 'deluxe_q_child_pax',
            'sea_quad_child_mat_pax' => 'deluxe_q_child_m_pax',
            'sea_quad_toddler_pax' => 'deluxe_q_toddler_pax',

            'sea_double_adult_price' => 'deluxe_d_adult_price',
            'sea_double_adult_mat_price' => 'deluxe_d_adult_m_price',

            'sea_double_child_price' => 'deluxe_d_child_price',
            'sea_double_child_mat_price' => 'deluxe_d_child_m_price',

            'sea_double_toddler_price' => 'deluxe_d_toddler_price',

            'sea_triple_adult_price' => 'deluxe_t_adult_price',

            'sea_triple_child_price' => 'deluxe_t_child_price',

            'sea_triple_toddler_price' => 'deluxe_t_toddler_price',

            'sea_quad_adult_price' => 'deluxe_q_adult_price',
            'sea_quad_adult_mat_price' => 'deluxe_q_adult_m_price',

            'sea_quad_child_price' => 'deluxe_q_child_price',
            'sea_quad_child_mat_price' => 'deluxe_q_child_m_price',

            'sea_quad_toddler_price' => 'deluxe_q_toddler_price',

        ];
        
        foreach ($fields as $key => $dbField) {
            $updateData[$dbField] = $pax[$key] ?? 0;
        }
        Bookings::query()
        ->where('booking_id', $bookingId)
        ->where('amend_id', $request->amendid)
        ->update($updateData);

        if ($paxRoom['room_double'] || $paxRoom['room_triple'] || $paxRoom['room_quad'] ||
        $paxRoom['room_sea_double'] || $paxRoom['room_sea_triple'] || $paxRoom['room_sea_quad']) {
            Bookings::query()
            ->where('booking_id', $bookingId)
            ->where('amend_id', $request->amendid)
            ->update([
                'room_double'    => $paxRoom['room_double'],
                'room_triple'    => $paxRoom['room_triple'],
                'room_quad'      => $paxRoom['room_quad'],
                'deluxe_double'  => $paxRoom['room_sea_double'],
                'deluxe_triple'  => $paxRoom['room_sea_triple'],
                'deluxe_quad'    => $paxRoom['room_sea_quad'],
            ]);
        }

        return response()->json([
            'message' => 'Dates updated successfully.',
        ]);
    }

    public function form3($bookingId, $amendId) {

        return view('form3', compact('bookingId', 'amendId'));
    }

    public function form4($bookingId, $amendId) {
        // Use the bookingId for logic or pass it to the view
        return view('form4', compact('bookingId','amendId'));
    }

    public function form5($bookingId, $amendId) {
        // Use the bookingId for logic or pass it to the view
        return view('form5', compact('bookingId', 'amendId'));
    }

    public function pickupDetails($bookingId, $amendId) {
        $pickups = PickupDetails::where('booking_id', $bookingId)->get();
        $total_pickup = number_format($pickups->sum('total_pickup_rate'), 2);

        $dropoffs = DropoffDetails::where('booking_id', $bookingId)->get();
        $total_dropoff = number_format($dropoffs->sum('total_dropoff_rate'), 2);

        $optionalArrangements = OptionalArrangementDetails::where('booking_id', $bookingId)->get();

        $pickupOptions = Pickup::pluck('pickup_name');
        $dropoffOptions = Dropoff::pluck('dropoff_name');
        $optionalOptions = OptionalArrangement::pluck('optional_name');

        //get data from original table - bookings
        $bookings = Bookings::query()
        ->where('booking_id', $bookingId)
        ->where('amend_id', $amendId)
        ->first();

        $optional_code01 = OptionalCodeBooking::query()
        ->where('booking_id', $bookingId)
        ->where('optional_id', 1)
        ->value('optional_code');
        $optional_code02 = OptionalCodeBooking::query()
        ->where('booking_id', $bookingId)
        ->where('optional_id', 2)
        ->value('optional_code');
        $optional_code03 = OptionalCodeBooking::query()
        ->where('booking_id', $bookingId)
        ->where('optional_id', 3)
        ->value('optional_code');
        $optional_code04 = OptionalCodeBooking::query()
        ->where('booking_id', $bookingId)
        ->where('optional_id', 4)
        ->value('optional_code');
        $optional_code05 = OptionalCodeBooking::query()
        ->where('booking_id', $bookingId)
        ->where('optional_id', 5)
        ->value('optional_code');

        $optional_code = [
            'optional_code01'   =>  $optional_code01,
            'optional_code02'   =>  $optional_code02,
            'optional_code03'   =>  $optional_code03,
            'optional_code04'   =>  $optional_code04,
            'optional_code05'   =>  $optional_code05
        ];

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

        $dive_package = $bookings->dive_pckg;
        $insurance = $bookings->insurance;

        return view('form3', compact('pickups', 'pickupOptions', 'dropoffs', 'dropoffOptions', 'total_pickup', 'total_dropoff', 'optionalArrangements', 'optionalOptions', 'total_optional', 'bookings', 'days', 'nights', 'package_total', 'land_transfer_total', 'optional_total', 'total_summary', 'dive_package', 'insurance', 'amendId', 'optional_code'));
    }

    public function getPickupDetails(Request $request)
    {
        if ($request->original == 'original') {
            if ($request->arrange_type == 'pickup'){
                if ($request->type == 'update rate') {
                    $pickup = Pickup::where('pickup_name', $request->pickup_name)->first();

                    if ($request->pickup_field == 'pickup01_method') {
                        $price_field = 'pickup01_price';
                    } else if ($request->pickup_field == 'pickup02_method') {
                        $price_field = 'pickup02_price';
                    } else {
                        $price_field = 'pickup03_price';
                    }

                    // if ($request->amendid == 0) {
                        Bookings::query()
                        ->where('booking_id', $request->booking_id)
                        ->where('amend_id', $request->amendid)
                        ->update([
                            $request->pickup_field   => $request->pickup_name,
                            $price_field    => $pickup->pickup_rate    
                        ]);
                    // } else {
                    //     BookingsAmend::query()
                    //     ->where('booking_id', $request->booking_id)
                    //     ->where('amend_id', $request->amendid)
                    //     ->update([
                    //         $request->pickup_field   => $request->pickup_name,
                    //         $price_field    => $pickup->pickup_rate    
                    //     ]);
                    // }

                    if ($pickup) {
                        return response()->json([
                            'success' => true
                        ]);
                    }
                } else {
                    // if ($request->amendid == 0) {
                        $find_pickup_details = Bookings::query()
                        ->where('booking_id', $request->booking_id)
                        ->where('amend_id', $request->amendid)
                        ->first();
                    // } else {
                    //     $find_pickup_details = BookingsAmend::query()
                    //     ->where('booking_id', $request->booking_id)
                    //     ->where('amend_id', $request->amendid)
                    //     ->first();
                    // }

                    if ($request->field == 'pickup01_method') {
                        $price = $find_pickup_details->pickup01_price;
                        $total_price_field = 'pickup01_total';
                        $pax_field = 'pickup01_pax';
                    } else if ($request->field == 'pickup02_method') {
                        $price = $find_pickup_details->pickup02_price;
                        $total_price_field = 'pickup02_total';
                        $pax_field = 'pickup02_pax';
                    } else {
                        $price = $find_pickup_details->pickup03_price;
                        $total_price_field = 'pickup03_total';
                        $pax_field = 'pickup03_pax';
                    }

                    $total_rate = $request->pickup_pax_value * $price;
                    // if ($request->amendid == 0) {
                        Bookings::query()
                        ->where('booking_id', $request->booking_id)
                        ->where('amend_id', $request->amendid)
                        ->update([
                            $pax_field => $request->pickup_pax_value,
                            $total_price_field => $total_rate
                        ]);
                    // } else {
                    //     BookingsAmend::query()
                    //     ->where('booking_id', $request->booking_id)
                    //     ->where('amend_id', $request->amendid)
                    //     ->update([
                    //         $pax_field => $request->pickup_pax_value,
                    //         $total_price_field => $total_rate
                    //     ]);
                    // }

                    $total_pickup = Bookings::query()
                    ->selectRaw('pickup01_total + pickup02_total + pickup03_total AS total_pickup')
                    ->where('booking_id', $request->booking_id)
                    ->where('amend_id', $request->amendid)
                    ->first();

                    return response()->json([
                        'success' => true,
                        'pickup_total_rate' => $total_rate,
                        'total_pickup' => $total_pickup->total_pickup
                    ]);
                }
            } else {
                if ($request->type == 'update rate') {
                    $dropoff = Dropoff::where('dropoff_name', $request->dropoff_name)->first();
                    if ($request->dropoff_field == 'dropoff01_method') {
                        $price_field = 'dropoff01_price';
                    } else if ($request->dropoff_field == 'dropoff02_method') {
                        $price_field = 'dropoff02_price';
                    } else {
                        $price_field = 'dropoff03_price';
                    }
                    // if ($request->amendid == 0) {
                        $bookings = Bookings::query()
                        ->where('booking_id', $request->booking_id)
                        ->where('amend_id', $request->amendid)
                        ->update([
                            $request->dropoff_field   => $request->dropoff_name,
                            $price_field    => $dropoff->dropoff_rate    
                        ]);
                    // } else {
                    //     $bookings = BookingsAmend::query()
                    //     ->where('booking_id', $request->booking_id)
                    //     ->where('amend_id', $request->amendid)
                    //     ->update([
                    //         $request->dropoff_field   => $request->dropoff_name,
                    //         $price_field    => $dropoff->dropoff_rate    
                    //     ]);
                    // }

                    if ($dropoff) {
                        return response()->json([
                            'success' => true
                        ]);
                    }
                } else {
                    // if ($request->amendid == 0) {
                        $find_dropoff_details = Bookings::query()
                        ->where('booking_id', $request->booking_id)
                        ->where('amend_id', $request->amendid)
                        ->first();
                    // } else {
                    //     $find_dropoff_details = BookingsAmend::query()
                    //     ->where('booking_id', $request->booking_id)
                    //     ->where('amend_id', $request->amendid)
                    //     ->first();
                    // }

                    if ($request->field == 'dropoff01_method') {
                        $price = $find_dropoff_details->dropoff01_price;
                        $total_price_field = 'dropoff01_total';
                        $pax_field = 'dropoff01_pax';
                    } else if ($request->field == 'dropoff02_method') {
                        $price = $find_dropoff_details->dropoff02_price;
                        $total_price_field = 'dropoff02_total';
                        $pax_field = 'dropoff02_pax';
                    } else {
                        $price = $find_dropoff_details->dropoff03_price;
                        $total_price_field = 'dropoff03_total';
                        $pax_field = 'dropoff03_pax';
                    }

                    $total_rate = $request->dropoff_pax_value * $price;
                    // if ($request->amendid == 0) {
                        Bookings::query()
                        ->where('booking_id', $request->booking_id)
                        ->where('amend_id', $request->amendid)
                        ->update([
                            $pax_field => $request->dropoff_pax_value,
                            $total_price_field => $total_rate
                        ]);
                    // } else {
                    //     BookingsAmend::query()
                    //     ->where('booking_id', $request->booking_id)
                    //     ->where('amend_id', $request->amendid)
                    //     ->update([
                    //         $pax_field => $request->dropoff_pax_value,
                    //         $total_price_field => $total_rate
                    //     ]);
                    // }

                    $total_dropoff = Bookings::query()
                    ->selectRaw('dropoff01_total + dropoff02_total + dropoff03_total AS total_dropoff')
                    ->where('booking_id', $request->booking_id)
                    ->first();

                    return response()->json([
                        'success' => true,
                        'dropoff_total_rate' => $total_rate,
                        'total_dropoff' => $total_dropoff->total_dropoff
                    ]);
                }
            }
        } else {
            if ($request->arrange_type == 'dropoff') {
                if ($request->type == 'update rate') {
                    // Fetch the data based on the selected pickup name
                    $dropoff = Dropoff::where('dropoff_name', $request->dropoff_name)->first();
        
                    DropoffDetails::query()
                    ->where('id', $request->dropoff_id)
                    ->update([
                        'dropoff_name' => $request->dropoff_name,
                        'dropoff_rate' => $dropoff->dropoff_rate,
                    ]);
        
                    if ($dropoff) {
                        return response()->json([
                            'success' => true,
                            'dropoff_pax' => $dropoff->dropoff_pax,
                            'dropoff_rate' => $dropoff->dropoff_rate,
                            'dropoff_total_rate' => 0,
                        ]);
                    }
                } else if ($request->type == 'add') {
                    DropoffDetails::create([
                        'booking_id' => $request->booking_id
                    ]);
        
                    return response()->json([
                        'success' => true
                    ]);
                } else {
                    $find_dropoff_details = dropoffDetails::query()
                    ->where('id', $request->dropoff_id)
                    ->where('booking_id', $request->booking_id)
                    ->first();
        
                    $total_rate = $request->dropoff_pax_value * $find_dropoff_details->dropoff_rate;
        
                    DropoffDetails::query()
                    ->where('id', $request->dropoff_id)
                    ->update([
                        'dropoff_pax' => $request->dropoff_pax_value,
                        'total_dropoff_rate' => $total_rate
                    ]);

                    return response()->json([
                        'success' => true,
                        'dropoff_total_rate' => $total_rate
                    ]);
                }
            // return response()->json(['success' => false, 'message' => 'Pickup not found']);
            } else if ($request->arrange_type == 'pickup'){
                if ($request->type == 'update rate') {
                    // Fetch the data based on the selected pickup name
                    $pickup = Pickup::where('pickup_name', $request->pickup_name)->first();

                    PickupDetails::query()
                    ->where('id', $request->pickup_id)
                    ->update([
                        'pickup_name' => $request->pickup_name,
                        'pickup_rate' => $pickup->pickup_rate,
                    ]);

                    if ($pickup) {
                        return response()->json([
                            'success' => true,
                            'pickup_pax' => $pickup->pickup_pax,
                            'pickup_rate' => $pickup->pickup_rate,
                            'pickup_total_rate' => 0,
                        ]);
                    }
                } else if ($request->type == 'add') {
                    PickupDetails::create([
                        'booking_id' => $request->booking_id
                    ]);

                    return response()->json([
                        'success' => true
                    ]);
                } else {
                    $find_pickup_details = pickupDetails::query()
                    ->where('id', $request->pickup_id)
                    ->where('booking_id', $request->booking_id)
                    ->first();

                    $total_rate = $request->pickup_pax_value * $find_pickup_details->pickup_rate;

                    PickupDetails::query()
                    ->where('id', $request->pickup_id)
                    ->update([
                        'pickup_pax' => $request->pickup_pax_value,
                        'total_pickup_rate' => $total_rate
                    ]);

                    $total_pickup = PickupDetails::query()
                    ->where('booking_id', $request->booking_id)
                    ->sum('total_pickup_rate');

                    return response()->json([
                        'success' => true,
                        'pickup_total_rate' => $total_rate,
                        'total_pickup' => $total_pickup
                    ]);
                }
            } else {
                if ($request->type == 'update rate') {
                    // Fetch the data based on the selected pickup name
                    $optional = OptionalArrangement::where('optional_name', $request->optional_name)->first();
        
                    if ($optional->dive_package == 1) {
                        // if ($request->amendid == 0) {
                            Bookings::query()
                            ->where('booking_id', $request->booking_id)
                            ->where('amend_id', $request->amendid)
                            ->update([
                                'dive_pckg' => 1
                            ]);
                        // } else {
                        //     BookingsAmend::query()
                        //     ->where('booking_id', $request->booking_id)
                        //     ->where('amend_id', $request->amendid)
                        //     ->update([
                        //         'dive_pckg' => 1
                        //     ]);
                        // }
                    }

                    OptionalArrangementDetails::query()
                    ->where('id', $request->optional_id)
                    ->update([
                        'optional_desc' => $request->optional_name,
                        'optional_price' => $optional->optional_rate,
                        'optional_sst' => $optional->optional_sst,
                        'optional_code' => $optional->optional_code,
                    ]);
        
                    if ($optional) {
                        return response()->json([
                            'success' => true,
                            'optional_price' => $optional->optional_price,
                            'optional_sst' => $optional->optional_sst,
                            'optional_code' => $optional->optional_code,
                            'optional_total' => 0,
                        ]);
                    }
                } else if ($request->type == 'add') {
                    OptionalArrangementDetails::create([
                        'booking_id' => $request->booking_id
                    ]);
        
                    return response()->json([
                        'success' => true
                    ]);
                } else {
                    $find_optional_details = OptionalArrangementDetails::query()
                    ->where('id', $request->optional_id)
                    ->where('booking_id', $request->booking_id)
                    ->first();
        
                    $total_rate = $request->optional_qty * $find_optional_details->optional_price;
        
                    OptionalArrangementDetails::query()
                    ->where('id', $request->optional_id)
                    ->update([
                        'optional_qty' => $request->optional_qty,
                        'optional_total' => $total_rate
                    ]);
        
                    return response()->json([
                        'success' => true,
                        'optional_total' => $total_rate
                    ]);
                }
        
            }
        }
        // return response()->json(['success' => false, 'message' => 'Pickup not found']);
    }

    public function optionalDetails($bookingId) {
        $optionalArrangements = OptionalArrangementDetails::where('booking_id', $bookingId)->get();
        $total_optional = number_format($optionalArrangements->sum('optional_total'), 2);

        $optionalOptions = OptionalArrangement::pluck('optional_name');
        return view('form4', compact('optionalArrangements', 'optionalOptions', 'total_optional'));
    }

    public function getOptionalDetails(Request $request)
    {
        if ($request->type == 'update rate') {
            // Fetch the data based on the selected pickup name
            $optional = OptionalArrangement::where('optional_name', $request->optional_name)->first();

            OptionalArrangementDetails::query()
            ->where('id', $request->optional_id)
            ->update([
                'optional_desc' => $request->optional_name,
                'optional_price' => $optional->optional_rate,
                'optional_sst' => $optional->optional_sst,
                'optional_code' => $optional->optional_code,
            ]);

            if ($optional) {
                return response()->json([
                    'success' => true,
                    'optional_price' => $optional->optional_price,
                    'optional_sst' => $optional->optional_sst,
                    'optional_code' => $optional->optional_code,
                    'optional_total' => 0,
                ]);
            }
        } else if ($request->type == 'add') {
            OptionalArrangementDetails::create([
                'booking_id' => $request->booking_id
            ]);

            return response()->json([
                'success' => true
            ]);
        } else {
            $find_optional_details = OptionalArrangementDetails::query()
            ->where('id', $request->optional_id)
            ->where('booking_id', $request->booking_id)
            ->first();

            $total_rate = $request->optional_qty * $find_optional_details->optional_price;

            OptionalArrangementDetails::query()
            ->where('id', $request->optional_id)
            ->update([
                'optional_qty' => $request->optional_qty,
                'optional_total' => $total_rate
            ]);

            return response()->json([
                'success' => true,
                'optional_total' => $total_rate
            ]);
        }
    }

    public function optionalOriginal(Request $request) {

        $optionalDetails = OptionalArrangement::query()
        ->where('optional_name', $request->optional_name)
        ->first();

        if ($request->optionalField == 'optional01_desc') {
            $price_field = 'optional01_price';
            $optional_sst = 'optional01_GST';
            $optional_id = 1;
        } else if ($request->optionalField == 'optional02_desc') {
            $price_field = 'optional02_price';
            $optional_sst = 'optional02_GST';
            $optional_id = 2;
        } else if ($request->optionalField == 'optional03_desc') {
            $price_field = 'optional03_price';
            $optional_sst = 'optional03_GST';
            $optional_id = 3;
        } else if ($request->optionalField == 'optional04_desc') {
            $price_field = 'optional04_price';
            $optional_sst = 'optional04_GST';
            $optional_id = 4;
        } else {
            $price_field = 'optional05_price';
            $optional_sst = 'optional05_GST';
            $optional_id = 5;
        }

        Bookings::query()
        ->where('booking_id', $request->booking_id)
        ->where('amend_id', $request->amendid)
        ->update([
            $request->optionalField => $request->optional_name,
            $price_field            => $optionalDetails->optional_rate,
            $optional_sst           => $optionalDetails->optional_sst,

        ]);

        OptionalCodeBooking::query()
        ->updateOrCreate(
            [
                'optional_id'   =>  $optional_id,
            ],
            [
                'booking_id'    =>  $request->booking_id,
                'optional_id'   =>  $optional_id,
                'optional_name' =>  $request->optional_name,
                'optional_code' =>  $optionalDetails->optional_code
            ]
        );

        if ($optionalDetails->dive_package == 1) {
            Bookings::query()
            ->where('booking_id', $request->booking_id)
            ->where('amend_id', $request->amendid)
            ->update([
                'dive_pckg'             =>  $optionalDetails->dive_package
            ]);
        }

        if ($optionalDetails) {
            return response()->json([
                'success' => true
            ]);
        }
    }

    public function updateQtyOptional(Request $request) {
        $descfield = $request->descfield;
        $qtyfield = $request->qtyfield;

        $bookingDetails = Bookings::query()
        ->where('booking_id', $request->booking_id)
        ->where('amend_id', $request->amendid)
        ->first();

        if ($request->descfield == 'optional01_desc') {
            $total_field = 'optional01_total';
            $qtyfield = $qtyfield;
            $total_optional = $request->newqtyValue * $bookingDetails->optional01_price;
        } else if ($request->descfield == 'optional02_desc') {
            $total_field = 'optional02_total';
            $qtyfield = $qtyfield;
            $total_optional = $request->newqtyValue * $bookingDetails->optional02_price;
        } else if ($request->descfield == 'optional03_desc') {
            $total_field = 'optional03_total';
            $qtyfield = $qtyfield;
            $total_optional = $request->newqtyValue * $bookingDetails->optional03_price;
        } else if ($request->descfield == 'optional04_desc') {
            $total_field = 'optional04_total';
            $qtyfield = $qtyfield;
            $total_optional = $request->newqtyValue * $bookingDetails->optional04_price;
        } else {
            $total_field = 'optional05_total';
            $qtyfield = $qtyfield;
            $total_optional = $request->newqtyValue * $bookingDetails->optional05_price;
        }

        Bookings::query()
        ->where('booking_id', $request->booking_id)
        ->where('amend_id', $request->amendid)
        ->update([
            $total_field    =>  $total_optional,
            $qtyfield       =>  $request->newqtyValue
        ]);

        return response()->json([
            'success' => true
        ]);

    }

    public function deleteoptional(Request $request) {
        if ($request->descfield == 'optional01_desc') {
            Bookings::query()
            ->where('booking_id', $request->booking_id)
            ->where('amend_id', $request->amendid)
            ->update([
                'optional01_desc' => '',
                'optional01_GST' => 0,
                'optional01_pax' => 0,
                'optional01_price' => 0,
                'optional01_total' => 0,
            ]);
        }
        if ($request->descfield == 'optional02_desc') {
            Bookings::query()
            ->where('booking_id', $request->booking_id)
            ->where('amend_id', $request->amendid)
            ->update([
                'optional02_desc' => '',
                'optional02_GST' => 0,
                'optional02_pax' => 0,
                'optional02_price' => 0,
                'optional02_total' => 0,
            ]);
        }
        if ($request->descfield == 'optional03_desc') {
            Bookings::query()
            ->where('booking_id', $request->booking_id)
            ->where('amend_id', $request->amendid)
            ->update([
                'optional03_desc' => '',
                'optional03_GST' => 0,
                'optional03_pax' => 0,
                'optional03_price' => 0,
                'optional03_total' => 0,
            ]);
        }
        if ($request->descfield == 'optional04_desc') {
            Bookings::query()
            ->where('booking_id', $request->booking_id)
            ->where('amend_id', $request->amendid)
            ->update([
                'optional04_desc' => '',
                'optional04_GST' => 0,
                'optional04_pax' => 0,
                'optional04_price' => 0,
                'optional04_total' => 0,
            ]);
        }
        if ($request->descfield == 'optional05_desc') {
            Bookings::query()
            ->where('booking_id', $request->booking_id)
            ->where('amend_id', $request->amendid)
            ->update([
                'optional05_desc' => '',
                'optional05_GST' => 0,
                'optional05_pax' => 0,
                'optional05_price' => 0,
                'optional05_total' => 0,
            ]);
        }

        return response()->json([
            'success' => true
        ]);
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

    public function totalDetails($bookingId, $amendId) {

        $bookings = Bookings::query()
        ->where('booking_id', $bookingId)
        ->where('amend_id', $amendId)
        ->first();

        $check_in = Carbon::parse( $bookings->check_in); // Start date
        $check_out = Carbon::parse( $bookings->check_out);   // End date

        $days = $check_in->diffInDays($check_out) + 1; // Including both start and end date
        $nights = $check_in->diffInDays($check_out); 

        $total_pickup = pickupDetails::query()
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
        $optional03total = 0;
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

        // $total_optional = $find_total_optional->optional01_total + $find_total_optional->optional02_total + $find_total_optional->optional03_total + $find_total_optional->optional04_total + $find_total_optional->optional05_total;
        $total_optional = $optional01_total + $optional02_total;
        $total_optional_no_sst = $optional01_total_no_sst + $optional02_total_no_sst;

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

        return view('form5', compact('bookings', 'total_optional_no_sst', 'total_sst',  'grand_total_with_sst', 'days', 'nights', 'total_amount_no_sst', 'deposit', 'amount_due', 'amendId', 'receipts', 'totalpay', 'lastpaid'));
    }

    public function savePayment(Request $request, $bookingId) {
        info($request->all()); // ✅ Logs the full request for debugging
    
        // ✅ Loop through each receipt in the `receiptData` array
        foreach ($request->receiptData as $receipt) {
            // ✅ Validate required fields (ensure 'ai_id' exists)
            if (!isset($receipt['ai_id']) || !isset($receipt['date']) || !isset($receipt['amount'])) {
                continue; // Skip incomplete records
            }
    
            // ✅ Get Payment From
            $payment_for = 'Security Deposit for Booking ' . $bookingId;
            $payment_from = Bookings::query()
                ->where('booking_id', $bookingId)
                ->where('amend_id', $receipt['amend_id']) // Use `$receipt['amend_id']` instead of `$request->amend_id`
                ->value('company');
    
            // ✅ Update each record properly
            Receipt::query()
                ->where('booking_id', $bookingId)
                ->where('AI_ID', $receipt['ai_id'])
                ->update([
                    'amount'        => $receipt['amount'] ?? 0, // Convert empty values to `0`
                    'bank'          => $receipt['bank'] ?? null, // Convert empty to `NULL`
                    'bank_details'  => $receipt['bank_details'] ?? null,
                    'paid_date'     => $receipt['date'] ?? null,
                    'issue_date'    => now(),
                    'payment_for'   => $payment_for,
                    'payment_from'  => $payment_from
                ]);
        }
    
        return response()->json(['success' => true, 'message' => 'Successfully updated']);
    }
    
    public function addPayment(Request $request, $bookingId) {
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

        return response()->json(['success' => true, 'message' => 'Successfully updated']);
    }

    public function deletePickup(Request $request,$id)
    {
        // $booking = Bookings::query()
        // ->where('booking_id', $id)
        // ->first();

        if ($request->original == 'original') {
            if ($request->arrange_type == 'pickup') {
                // if ($request->amendid == 0) {
                    if ($request->pickupmethod == 'pickup01_method') {
                        Bookings::query()
                        ->where('booking_id', $id)
                        ->where('amend_id', $request->amendid)
                        ->update([
                            'pickup01_method' => '',
                            'pickup01_pax' => 0,
                            'pickup01_price' => 0,
                            'pickup01_total' => 0,
                        ]);
                    }
                    if ($request->pickupmethod == 'pickup02_method') {
                        Bookings::query()
                        ->where('booking_id', $id)
                        ->where('amend_id', $request->amendid)
                        ->update([
                            'pickup02_method' => '',
                            'pickup02_pax' => 0,
                            'pickup02_price' => 0,
                            'pickup02_total' => 0,
                        ]);
                    }
                    if ($request->pickupmethod == 'pickup03_method') {
                        Bookings::query()
                        ->where('booking_id', $id)
                        ->where('amend_id', $request->amendid)
                        ->update([
                            'pickup03_method' => '',
                            'pickup03_pax' => 0,
                            'pickup03_price' => 0,
                            'pickup03_total' => 0,
                        ]);
                    }
                // } else {
                //     if ($request->pickupmethod == 'pickup01_method') {
                //         BookingsAmend::query()
                //         ->where('booking_id', $id)
                //         ->where('amend_id', $request->amendid)
                //         ->update([
                //             'pickup01_method' => '',
                //             'pickup01_pax' => 0,
                //             'pickup01_price' => 0,
                //             'pickup01_total' => 0,
                //         ]);
                //     }
                //     if ($request->pickupmethod == 'pickup02_method') {
                //         BookingsAmend::query()
                //         ->where('booking_id', $id)
                //         ->where('amend_id', $request->amendid)
                //         ->update([
                //             'pickup02_method' => '',
                //             'pickup02_pax' => 0,
                //             'pickup02_price' => 0,
                //             'pickup02_total' => 0,
                //         ]);
                //     }
                //     if ($request->pickupmethod == 'pickup03_method') {
                //         BookingsAmend::query()
                //         ->where('booking_id', $id)
                //         ->where('amend_id', $request->amendid)
                //         ->update([
                //             'pickup03_method' => '',
                //             'pickup03_pax' => 0,
                //             'pickup03_price' => 0,
                //             'pickup03_total' => 0,
                //         ]);
                //     }

                // }
            } else {
                // if ($request->amendid == 0) {
                    if ($request->dropoffmethod == 'dropoff01_method') {
                        Bookings::query()
                        ->where('booking_id', $id)
                        ->where('amend_id', $request->amendid)
                        ->update([
                            'dropoff01_method' => '',
                            'dropoff01_pax' => 0,
                            'dropoff01_price' => 0,
                            'dropoff01_total' => 0,
                        ]);
                    }
                    if ($request->dropoffmethod == 'dropoff02_method') {
                        Bookings::query()
                        ->where('booking_id', $id)
                        ->where('amend_id', $request->amendid)
                        ->update([
                            'dropoff02_method' => '',
                            'dropoff02_pax' => 0,
                            'dropoff02_price' => 0,
                            'dropoff02_total' => 0,
                        ]);
                    }
                    if ($request->dropoffmethod == 'dropoff03_method') {
                        Bookings::query()
                        ->where('booking_id', $id)
                        ->where('amend_id', $request->amendid)
                        ->update([
                            'dropoff03_method' => '',
                            'dropoff03_pax' => 0,
                            'dropoff03_price' => 0,
                            'dropoff03_total' => 0,
                        ]);
                    }
                // } else {
                //     if ($request->dropoffmethod == 'dropoff01_method') {
                //         BookingsAmend::query()
                //         ->where('booking_id', $id)
                //         ->where('amend_id', $request->amendid)
                //         ->update([
                //             'dropoff01_method' => '',
                //             'dropoff01_pax' => 0,
                //             'dropoff01_price' => 0,
                //             'dropoff01_total' => 0,
                //         ]);
                //     }
                //     if ($request->dropoffmethod == 'dropoff02_method') {
                //         BookingsAmend::query()
                //         ->where('booking_id', $id)
                //         ->where('amend_id', $request->amendid)
                //         ->update([
                //             'dropoff02_method' => '',
                //             'dropoff02_pax' => 0,
                //             'dropoff02_price' => 0,
                //             'dropoff02_total' => 0,
                //         ]);
                //     }
                //     if ($request->dropoffmethod == 'dropoff03_method') {
                //         BookingsAmend::query()
                //         ->where('booking_id', $id)
                //         ->where('amend_id', $request->amendid)
                //         ->update([
                //             'dropoff03_method' => '',
                //             'dropoff03_pax' => 0,
                //             'dropoff03_price' => 0,
                //             'dropoff03_total' => 0,
                //         ]);
                //     }

                // }
            }
        } else {
            if ($request->arrange_type == 'pickup') {
                PickupDetails::query()
                    ->where('id', $request->pickupid)
                    ->where('booking_id', $id)
                    ->delete();
            } else {
                DropoffDetails::query()
                    ->where('id', $request->dropoffid)
                    ->where('booking_id', $id)
                    ->delete();
            }
        }
        if ($request->arrange_type == 'pickup') {
            return response()->json(['success' => true, 'message' => 'Pickup method deleted successfully']);
        } else {
            return response()->json(['success' => true, 'message' => 'Dropoff method deleted successfully']);
        }
    }

    public function changeDeposit(Request $request,$id) {
        Bookings::query()
        ->where('booking_id', $id)
        ->update([
            'deposit_amount' => $request->value,
        ]);

        return response()->json(['success' => true, 'message' => 'Successfully updated']);
    }


}
