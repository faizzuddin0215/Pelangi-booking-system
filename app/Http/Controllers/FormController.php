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
                'agent' => 0,
                'dive_pckg' => 0,
                'insurance' => 0,
                // 'check_in' => 0,
                // 'check_out' => 0,
                'pax_adult' => 0,
                'pax_child' => 0,
                'pax_toddler' => 0,
                'pax_foc_tl' => 0,
                'booking_id' => 0,
                'amend_id' => 0,
                'company_frml' => '',
                'company_ID' => 0,
                'GST_ID' => '',
                'group_name' => '',
                'group_contact' => '',
                'name_list' => 0,
                'bb_pckg' => 0,
                'seaview' => 0,
                'resort' => 0,
                'AM_Rooms' => 0,
                'room_double' => 0,
                'room_double_m' => 0,
                'room_triple' => 0,
                'room_triple_m' => 0,
                'room_quad' => 0,
                'room_quad_m' => 0,
                'deluxe_double' => 0,
                'deluxe_double_m' => 0,
                'deluxe_triple' => 0,
                'deluxe_triple_m' => 0,
                'deluxe_quad' => 0,
                'deluxe_quad_m' => 0,
                'room_D1' => 0,
                'room_D2' => 0,
                'room_tour_leader' => 0,
                'room_tour_leader_female' => 0,
                'd_adult_pax' => 0,
                'd_adult_price' => 0,
                'd_adult_frml' => '=Calculation!I23',
                'd_adult_m_pax' => 0,
                'd_adult_m_price' => 0,
                'd_adult_m_frml' => '=Calculation!K23',
                'd_child_pax' => 0,
                'd_child_price' => 0,
                'd_child_frml' => '=Calculation!I23',
                'd_child_m_pax' => 0,
                'd_child_m_price' => 0,
                'd_child_m_frml' => '=Calculation!L23',
                'd_toddler_pax' => 0,
                'd_toddler_price' => 0,
                't_adult_pax' => 0,
                't_adult_price' => 0,
                't_adult_frml' => '=IF(SUM(R16:R17)<>0, T16,Calculation!M23)',
                't_adult_m_pax' => 0,
                't_adult_m_price' => 0,
                't_adult_m_frml' => '=IF(SUM(R16:R17)<>0,L16,0)',
                't_child_pax' => 0,
                't_child_price' => 0,
                't_child_frml' => '=IF(SUM(R16:R17)<>0, T17,Calculation!N23)',
                't_child_m_pax' => 0,
                't_child_m_price' => 0,
                't_child_m_frml' => '=IF(SUM(R16:R17)<>0,L17,0)',
                't_toddler_pax' => 0,
                't_toddler_price' => 0,
                'q_adult_pax' => 0,
                'q_adult_price' => 0,
                'q_adult_frml' => '=Calculation!O23',
                'q_adult_m_pax' => 0,
                'q_adult_m_price' => 0,
                'q_adult_m_frml' => '=Calculation!Q23',
                'q_child_pax' => 0,
                'q_child_price' => 0,
                'q_child_frml' => '=Calculation!P23',
                'q_child_m_pax' => 0,
                'q_child_m_price' => 0,
                'q_child_m_frml' => '=Calculation!R23',
                'q_toddler_pax' => 0,
                'q_toddler_price' => 0,
                'deluxe_d_adult_pax' => 0,
                'deluxe_d_adult_price' => 0,
                'deluxe_d_adult_frml' => '=Calculation!I23+Calculation!S23',
                'deluxe_d_adult_m_pax' => 0,
                'deluxe_d_adult_m_price' => 0,
                'deluxe_d_adult_m_frml' => '=Calculation!K23+Calculation!S23',
                'deluxe_d_child_pax' => 0,
                'deluxe_d_child_price' => 0,
                'deluxe_d_child_frml' => '=Calculation!I23+Calculation!S23',
                'deluxe_d_child_m_pax' => 0,
                'deluxe_d_child_m_price' => 0,
                'deluxe_d_child_m_frml' => '=Calculation!L23+Calculation!S23',
                'deluxe_d_toddler_pax' => 0,
                'deluxe_d_toddler_price' => 0,
                'deluxe_t_adult_pax' => 0,
                'deluxe_t_adult_price' => 0,
                'deluxe_t_adult_frml' => '=IF(SUM(R22:R23)<>0, T22,Calculation!M23+Calculation!S23)',
                'deluxe_t_adult_m_pax' => 0,
                'deluxe_t_adult_m_price' => 0,
                'deluxe_t_adult_m_frml' => '=IF(SUM(R22:R23)<>0,L22,0)',
                'deluxe_t_child_pax' => 0,
                'deluxe_t_child_price' => 0,
                'deluxe_t_child_frml' => '=IF(SUM(R22:R23)<>0, T23,Calculation!N23+Calculation!S23)',
                'deluxe_t_child_m_pax' => 0,
                'deluxe_t_child_m_price' => 0,
                'deluxe_t_child_m_frml' => '=IF(SUM(R22:R23)<>0,L23,0)',
                'deluxe_t_toddler_pax' => 0,
                'deluxe_t_toddler_price' => 0,
                'deluxe_q_adult_pax' => 0,
                'deluxe_q_adult_price' => 0,
                'deluxe_q_adult_frml' => '=Calculation!O23+Calculation!S23',
                'deluxe_q_adult_m_pax' => 0,
                'deluxe_q_adult_m_price' => 0,
                'deluxe_q_adult_m_frml' => '=Calculation!Q23+Calculation!S23',
                'deluxe_q_child_pax' => 0,
                'deluxe_q_child_price' => 0,
                'deluxe_q_child_frml' => '=Calculation!P23+Calculation!S23',
                'deluxe_q_child_m_pax' => 0,
                'deluxe_q_child_m_price' => 0,
                'deluxe_q_child_m_frml' => '=Calculation!R23+Calculation!S23',
                'deluxe_q_toddler_pax' => 0,
                'deluxe_q_toddler_price' => 0,
                'pickup01_method' => '',
                'pickup01_pax' => 0,
                'pickup01_price' => 0,
                'pickup01_total' => 0,
                'pickup02_method' => '',
                'pickup02_pax' => 0,
                'pickup02_price' => 0,
                'pickup02_total' => 0,
                'pickup03_method' => '',
                'pickup03_pax' => 0,
                'pickup03_price' => 0,
                'pickup03_total' => 0,
                'pickup_total' => 0,
                'dropoff01_method' => '',
                'dropoff01_pax' => 0,
                'dropoff01_price' => 0,
                'dropoff01_total' => 0,
                'dropoff02_method' => '',
                'dropoff02_pax' => 0,
                'dropoff02_price' => 0,
                'dropoff02_total' => 0,
                'dropoff03_method' => '',
                'dropoff03_pax' => 0,
                'dropoff03_price' => 0,
                'dropoff03_total' => 0,
                'dropoff_total' => 0,
                'optional01_desc' => '',
                'optional01_GST' => 0,
                'optional01_bill_to' => '',
                'optional01_pax' => 0,
                'optional01_price' => 0,
                'optional01_total' => 0,
                'optional02_desc' => '',
                'optional02_GST' => 0,
                'optional02_bill_to' => '',
                'optional02_pax' => 0,
                'optional02_price' => 0,
                'optional02_total' => 0,
                'optional03_desc' => '',
                'optional03_GST' => 0,
                'optional03_bill_to' => '',
                'optional03_pax' => 0,
                'optional03_price' => 0,
                'optional03_total' => 0,
                'optional04_desc' => '',
                'optional04_GST' => 0,
                'optional04_bill_to' => '',
                'optional04_pax' => 0,
                'optional04_price' => 0,
                'optional04_total' => 0,
                'optional05_desc' => '',
                'optional05_GST' => 0,
                'optional05_bill_to' => '',
                'optional05_pax' => 0,
                'optional05_price' => 0,
                'optional05_total' => 0,
                'optional_total' => 0,
                'package_total' => 0,
                'landtransfer_total' => 0,
                'others_total' => 0,
                'others_total_with_No_GST' => 0,
                'grand_total' => 0,
                'GST' => 0,
                'grand_total_with_GST' => 0,
                'deposit_amount' => 0,
                'deposit_frml' => '=(D12+H12)*200',
                'deposit_due_date' => $formattedDate,
                'balance_amount' => 0,
                'balance_due_date' => $formattedDate,
                'remarks_customer' => '',
                'internal_remarks' => '',
                'divecentre_remarks' => '',
                'amend01' => '',
                'amend02' => '',
                'amend03' => '',
                'amend04' => '',
                'amend05' => '',
                'amend06' => '',
                'amend07' => '',
                'amend08' => '',
                'amend09' => '',
                'amend10' => '',
                'total_paid' => 0,
                'actual_balance' => 0,
                'invoice_no' => 0,
                'total_paid_vh' => 0,
                'invoice_no_vh' => 0,
                'vh_comm' => 0,
                'rooms_allocated' => 0,
                'duplicated_VH' => 0,
                'duplicated_DR' => 0,
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
            if ($request->saveForm == 'saveForm') {
                return redirect('form?booking=' . $bookingId . '&amend=' . $request->amendid);
            } else {
                return redirect('form2/' . $bookingId . '/' . $request->amendid);
            }
            
        } else {
            if ($request->saveForm == 'saveForm') {
                return redirect('form?booking=' . $bookingId . '&amend=' . 0);
            } else {
                return redirect('form2/' . $bookingId . '/' . 0);
            }
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
        $booking = Bookings::where('booking_id', $bookingId)->where('amend_id', $amendID)->first();

        $amendBooking = Bookings::query()
        ->where('booking_id', $bookingId)
        ->where('amend_id', '>', 0)
        ->get();

        $password = NamelistUser::where('booking_id', $bookingId)->value('password');

        $optional01_total = 0;
        $optional02_total = 0;
        $optional03_total = 0;
        $optional04_total = 0;
        $optional05_total = 0;

        $optional01_total_no_sst = 0;
        $optional02_total_no_sst = 0;
        $optional03_total_no_sst = 0;
        $optional04_total_no_sst = 0;
        $optional05_total_no_sst = 0;

        if ($booking->optional01_GST == 1) {
            $optional01_total = $booking->optional01_total;
        } else {
            $optional01_total_no_sst = $booking->optional01_total;
        }

        if ($booking->optional02_GST == 1) {
            $optional02_total = $booking->optional02_total;
        } else {
            $optional02_total_no_sst = $booking->optional02_total;
        }

        if ($booking->optional03_GST == 1) {
            $optional03_total = $booking->optional03_total;
        } else {
            $optional03_total_no_sst = $booking->optional03_total;
        }

        if ($booking->optional04_GST == 1) {
            $optional04_total = $booking->optional04_total;
        } else {
            $optional04_total_no_sst = $booking->optional04_total;
        }

        if ($booking->optional05_GST == 1) {
            $optional05_total = $booking->optional05_total;
        } else {
            $optional05_total_no_sst = $booking->optional05_total;
        }

        $total_optional = $optional01_total + $optional02_total + $optional03_total + $optional04_total + $optional05_total;
        $total_optional_no_sst = $optional01_total_no_sst + $optional02_total_no_sst + $optional03_total_no_sst + $optional04_total_no_sst + $optional05_total_no_sst;
        if ($booking) {
            return response()->json([
                'success' => true,
                'password'=> $password,
                'booking' => $booking,
                'amendBooking' => $amendBooking,
                'total_optional_no_sst' => $total_optional_no_sst
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
    


}
