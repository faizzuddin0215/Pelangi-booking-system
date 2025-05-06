<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\NamelistUser;
use App\Models\Rates;
use App\Models\Room;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckRateController extends Controller
{
    public function check_rate() {
        // Use the bookingId for logic or pass it to the view
        // return view('check_rate', compact('bookingId', 'amendId'));
        return view('check_rate');
    }

    public function changeValue(Request $request) {   
        $check_in = Carbon::parse( $request->check_in); // Start date
        $check_out = Carbon::parse( $request->check_out);   // End date

        $days = $check_in->diffInDays($check_out) + 1; // Including both start and end date
        $nights = $check_in->diffInDays($check_out); 
        
        $days = $days;

        if ($request->type == 'date') {

            $extra_charge_adult = 0;
            $extra_charge_child = 0;

            $rates = DB::table('calendar as c')
            ->join('rates as r', 'c.price_ID', '=', 'r.price_ID')
            ->where('c.dates', $check_in)
            ->select('c.*', 'r.*')
            ->first();

            if ($request->agentTier == 1) {
                $rates = Rates::query()
                ->where('weekend', $rates->price_ID)
                ->whereIn('price_ID', [704, 705, 706])
                ->first();
            } elseif ($request->agentTier == 2) {
                $rates = Rates::query()
                ->where('weekend', $rates->price_ID)
                ->whereIn('price_ID', [716, 717, 718])
                ->first();
            } else {
                $rates = DB::table('calendar as c')
                ->join('rates as r', 'c.price_ID', '=', 'r.price_ID')
                ->where('c.dates', $check_in)
                ->select('c.*', 'r.*')
                ->first();
            }

            $holiday_rates = 0;

            if ($days >= 3) {
                $date_after_two_night = $check_in->addDays(2);
                $previousDate = $check_out->subDay();

                if ($days > 3) {
                    $add_rates = DB::table('calendar as c')
                    ->join('rates as r', 'c.price_ID', '=', 'r.price_ID')
                    ->whereBetween('c.dates', [$date_after_two_night, $previousDate])
                    ->select('c.*', 'r.*')
                    ->get();  

                    $extra_charge_adult = $add_rates->sum('add_a');
                    $extra_charge_child = $add_rates->sum('add_c');

                    if ($request->agentTier == 1) {
                        foreach ($add_rates as $rowt1) {
                            $add_rates = Rates::query()
                            ->where('weekend', $rowt1->price_ID)
                            ->whereIn('price_ID', [704, 705, 706])
                            ->first();
                            $extra_charge_adult += $add_rates->add_a;
                            $extra_charge_child += $add_rates->add_c;
                        }
                    } elseif ($request->agentTier == 2) {
                        foreach ($add_rates as $rowt2) {
                            $add_rates = Rates::query()
                            ->where('weekend', $rowt2->price_ID)
                            ->whereIn('price_ID', [716, 717, 718])
                            ->first();

                            $extra_charge_adult += $add_rates->add_a;
                            $extra_charge_child += $add_rates->add_c;
                        }
                    }
                }
    
                $chck_in = Carbon::parse( $request->check_in);
                $chck_out = Carbon::parse( $request->check_out)->subDay();
                $find_rate_school_hol = DB::table('calendar as c')
                ->join('rates as r', 'c.price_ID', '=', 'r.price_ID')
                ->whereBetween('c.dates', [$chck_in, $chck_out])
                ->select('c.*', 'r.*')
                ->get();
                $holiday_rates = 0;
                foreach ($find_rate_school_hol as $row) {
                    if ($row->school_hol == 1) {
                        $holiday_rates += 25;
                    }
                }

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

            $pax = [
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
                'agent'                  => $request['agentTier'],
            ];
            
            return response()->json([
                'message' => 'Dates updated successfully.',
                'days' => $days,
                'nights' => $nights,
                'pax' => $pax
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
            $quad_adult_mat_pax = $this->safeMultiply($quad_pax['adult_mat'], $quad_price['adult_mat']);
            $quad_child_pax = $this->safeMultiply($quad_pax['child'], $quad_price['child']);
            $quad_child_mat_pax = $this->safeMultiply($quad_pax['child_mat'], $quad_price['child_mat']);
            $quad_toddler_pax = $this->safeMultiply($quad_pax['toddler'], $quad_price['toddler']);
            $total_quad_rates = $quad_adult_pax + $quad_adult_mat_pax + $quad_child_pax + $quad_child_mat_pax + $quad_toddler_pax;
            $sum_quad_pax = (floatval($quad_pax['adult']) +  floatval($quad_pax['child'])) / 4; // + $request->pax['quad_toddler_pax'];
            $sum_quad_mat_pax = floatval($quad_pax['adult_mat']) + floatval($quad_pax['child_mat']);

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

    public function safeMultiply($a, $b)
    {
        return floatval($a) * floatval($b);
    }

    public function saveValue(Request $request) {
        $total_room = 51;
        $roomsRequested = 0;
        
        foreach ($request->paxRoom as $key => $value) {
            if (str_starts_with($key, 'room_')) {
                $roomsRequested += (int)$value;
            } else {
                $roomsRequested += (int)$value;
            }
        }
        $roomsAlreadyBooked = Room::where('check_in', '<=', $request->check_in)
        ->where('check_out', '>', $request->check_in)
        ->whereNotIn('room_type', ['TLF', 'TL', 'D1', 'D2'])
        ->count();

        $availableRooms = $total_room - $roomsAlreadyBooked;
        if ($roomsRequested > $availableRooms) {
            return response()->json([
                'result' => 'Room not available on these dates: ' . $request->check_in.', '.$request->check_out,
                'status' => 'error'
            ]);
        } else {
            // if 51 rooms, will be using spare room
            if ($availableRooms == 1 && $roomsRequested == 1) {
                return response()->json([
                    'result' => 'Room will be using a spare room.',
                    'status' => 'spare'
                ]);
            } else {
                $paxRoom = $request->paxRoom;
                $pax = $request->pax;
        
                $formattedDate = Carbon::today()->format('Y-m-d');
                $generatedPassword = Str::random(10);
                $updateData = [
                    // Primary request and calculated values
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
                    'deluxe_quad'    => $paxRoom['sea_quad'],
                
                    // Customer & booking details
                    'attention'      => $request['name'],
                    'company'        => $request['company'],
                    'address'        => $request['address'] ?? '',
                    'telephone'      => $request['telephone'],
                    'fax'            => $request['fax'],
                    'email'          => $request['email'],
                    'group_name'     => $request['contactname'],
                    'group_contact'  => $request['contactno'],
                    'handle_by'      => Auth::user()->name,
                    'date'           => $formattedDate,
                    'leads'          => $request['lead'] ?? 0,
                    'cancel'         => 0,
                
                    // Financial & room-related (static/default values)
                    'agent'                      => 0,
                    'dive_pckg'                  => 0,
                    'booking_id'                => 0,
                    'amend_id'                  => 0,
                    'company_frml'              => '',
                    'company_ID'                => 0,
                    'GST_ID'                    => '',
                    'name_list'                 => 0,
                    'bb_pckg'                   => 0,
                    'seaview'                   => 0,
                    'resort'                    => 0,
                    'AM_Rooms'                  => 0,
                    'room_double_m'             => 0,
                    'room_triple_m'             => 0,
                    'room_quad_m'               => 0,
                    'deluxe_double_m'           => 0,
                    'deluxe_triple_m'           => 0,
                    'deluxe_quad_m'             => 0,
                    'room_D1'                   => 0,
                    'room_D2'                   => 0,
                    'room_tour_leader'          => 0,
                    'room_tour_leader_female'   => 0,
                
                    // Deposit & balance
                    'deposit_frml'              => '=(D12+H12)*200',
                    'deposit_due_date'          => $formattedDate,
                    'balance_amount'            => 0,
                    'balance_due_date'          => $formattedDate,
                
                    // Remarks
                    'remarks_customer'          => '',
                    'internal_remarks'          => '',
                    'divecentre_remarks'        => '',
                
                    // Amendments and system control
                    'amend01' => '', 'amend02' => '', 'amend03' => '', 'amend04' => '',
                    'amend05' => '', 'amend06' => '', 'amend07' => '', 'amend08' => '',
                    'amend09' => '', 'amend10' => '',
                    
                    // Payment
                    'total_paid'                => 0,
                    'actual_balance'            => 0,
                    'invoice_no'                => 0,
                    'total_paid_vh'             => 0,
                    'invoice_no_vh'             => 0,
                    'vh_comm'                   => 0,
                
                    // Status
                    'rooms_allocated'           => 0,
                    'duplicated_VH'             => 0,
                    'duplicated_DR'             => 0,
                
                    // Totals (cleaned)
                    'landtransfer_total'        => 0,
                    'others_total'              => 0,
                    'others_total_with_No_GST'  => 0,
                    'grand_total'               => 0,
                    'GST'                       => 0,
                    'grand_total_with_GST'      => 0,
                    'deposit_amount'            => 0,
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
                // Bookings::query()
                // ->where('booking_id', $bookingId)
                // ->where('amend_id', $request->amendid)
                // ->update($updateData);
        
                $booking = Bookings::create($updateData);
                $bookingId = $booking->booking_id;
        
                if ($paxRoom['room_double'] || $paxRoom['room_triple'] || $paxRoom['room_quad'] ||
                $paxRoom['room_sea_double'] || $paxRoom['room_sea_triple'] || $paxRoom['room_sea_quad']) {
                    Bookings::query()
                    ->where('booking_id', $bookingId)
                    ->update([
                        'room_double'    => $paxRoom['room_double'],
                        'room_triple'    => $paxRoom['room_triple'],
                        'room_quad'      => $paxRoom['room_quad'],
                        'deluxe_double'  => $paxRoom['room_sea_double'],
                        'deluxe_triple'  => $paxRoom['room_sea_triple'],
                        'deluxe_quad'    => $paxRoom['room_sea_quad'],
                    ]);
                }
        
                NamelistUser::insert([
                    'booking_ID' => $bookingId,
                    'password'   => $generatedPassword,
                    'group_name' => '',
                    'group_contact' => '',
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
        
                $nights = Carbon::parse($request->check_in)->diffInDays(Carbon::parse($request->check_out));
                foreach ($request->paxRoom as $key => $value) {
                    if (str_starts_with($key, 'room_') && (int)$value > 0) {
                
                        // Determine room type code
                        switch ($key) {
                            case 'room_double':
                                $room = 'D';
                                break;
                            case 'room_triple':
                                $room = 'T';
                                break;
                            case 'room_quad':
                                $room = 'Q';
                                break;
                            case 'room_sea_double':
                                $room = 'Deluxe_D';
                                break;
                            case 'room_sea_triple':
                                $room = 'Deluxe_T';
                                break;
                            case 'room_sea_quad':
                                $room = 'Deluxe_Q';
                                break;
                            default:
                                $room = 'Unknown';
                        }
                
                        for ($i = 1; $i <= (int)$value; $i++) {
                            Room::insert([
                                'check_in' => $request->check_in,
                                'check_out' => $request->check_out,
                                'nights' => $nights,
                                'rooms' => '',
                                'booking_id' => $bookingId,
                                'room_type' => $room
                            ]);
                        }
                    } else {
                        // Determine room type code
                        switch ($key) {
                            case 'double':
                                $room = 'D';
                                break;
                            case 'triple':
                                $room = 'T';
                                break;
                            case 'quad':
                                $room = 'Q';
                                break;
                            case 'sea_double':
                                $room = 'Deluxe_D';
                                break;
                            case 'sea_triple':
                                $room = 'Deluxe_T';
                                break;
                            case 'sea_quad':
                                $room = 'Deluxe_Q';
                                break;
                            default:
                                $room = 'Unknown';
                        }
                
                        for ($i = 1; $i <= (int)$value; $i++) {
                            Room::insert([
                                'check_in' => $request->check_in,
                                'check_out' => $request->check_out,
                                'nights' => $nights,
                                'rooms' => '',
                                'booking_id' => $bookingId,
                                'room_type' => $room
                            ]);
                        }
                    }
                }
            }
    
            return response()->json([
                'bookingID' =>$bookingId,
            ]);
        }
        
    }

    public function saveSpareRoom(Request $request) {
        $paxRoom = $request->paxRoom;
        $pax = $request->pax;

        $formattedDate = Carbon::today()->format('Y-m-d');
        $generatedPassword = Str::random(10);
        $updateData = [
            // Primary request and calculated values
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
            'deluxe_quad'    => $paxRoom['sea_quad'],
        
            // Customer & booking details
            'attention'      => $request['name'],
            'company'        => $request['company'],
            'address'        => $request['address'] ?? '',
            'telephone'      => $request['telephone'],
            'fax'            => $request['fax'],
            'email'          => $request['email'],
            'group_name'     => $request['contactname'],
            'group_contact'  => $request['contactno'],
            'handle_by'      => Auth::user()->name,
            'date'           => $formattedDate,
            'leads'          => $request['lead'] ?? 0,
            'cancel'         => 0,
        
            // Financial & room-related (static/default values)
            'agent'                      => 0,
            'dive_pckg'                  => 0,
            'booking_id'                => 0,
            'amend_id'                  => 0,
            'company_frml'              => '',
            'company_ID'                => 0,
            'GST_ID'                    => '',
            'name_list'                 => 0,
            'bb_pckg'                   => 0,
            'seaview'                   => 0,
            'resort'                    => 0,
            'AM_Rooms'                  => 0,
            'room_double_m'             => 0,
            'room_triple_m'             => 0,
            'room_quad_m'               => 0,
            'deluxe_double_m'           => 0,
            'deluxe_triple_m'           => 0,
            'deluxe_quad_m'             => 0,
            'room_D1'                   => 0,
            'room_D2'                   => 0,
            'room_tour_leader'          => 0,
            'room_tour_leader_female'   => 0,
        
            // Deposit & balance
            'deposit_frml'              => '=(D12+H12)*200',
            'deposit_due_date'          => $formattedDate,
            'balance_amount'            => 0,
            'balance_due_date'          => $formattedDate,
        
            // Remarks
            'remarks_customer'          => '',
            'internal_remarks'          => '',
            'divecentre_remarks'        => '',
        
            // Amendments and system control
            'amend01' => '', 'amend02' => '', 'amend03' => '', 'amend04' => '',
            'amend05' => '', 'amend06' => '', 'amend07' => '', 'amend08' => '',
            'amend09' => '', 'amend10' => '',
            
            // Payment
            'total_paid'                => 0,
            'actual_balance'            => 0,
            'invoice_no'                => 0,
            'total_paid_vh'             => 0,
            'invoice_no_vh'             => 0,
            'vh_comm'                   => 0,
        
            // Status
            'rooms_allocated'           => 0,
            'duplicated_VH'             => 0,
            'duplicated_DR'             => 0,
        
            // Totals (cleaned)
            'landtransfer_total'        => 0,
            'others_total'              => 0,
            'others_total_with_No_GST'  => 0,
            'grand_total'               => 0,
            'GST'                       => 0,
            'grand_total_with_GST'      => 0,
            'deposit_amount'            => 0,
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
        // Bookings::query()
        // ->where('booking_id', $bookingId)
        // ->where('amend_id', $request->amendid)
        // ->update($updateData);

        $booking = Bookings::create($updateData);
        $bookingId = $booking->booking_id;

        if ($paxRoom['room_double'] || $paxRoom['room_triple'] || $paxRoom['room_quad'] ||
        $paxRoom['room_sea_double'] || $paxRoom['room_sea_triple'] || $paxRoom['room_sea_quad']) {
            Bookings::query()
            ->where('booking_id', $bookingId)
            ->update([
                'room_double'    => $paxRoom['room_double'],
                'room_triple'    => $paxRoom['room_triple'],
                'room_quad'      => $paxRoom['room_quad'],
                'deluxe_double'  => $paxRoom['room_sea_double'],
                'deluxe_triple'  => $paxRoom['room_sea_triple'],
                'deluxe_quad'    => $paxRoom['room_sea_quad'],
            ]);
        }

        NamelistUser::insert([
            'booking_ID' => $bookingId,
            'password'   => $generatedPassword,
            'group_name' => '',
            'group_contact' => '',
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

        $nights = Carbon::parse($request->check_in)->diffInDays(Carbon::parse($request->check_out));
        foreach ($request->paxRoom as $key => $value) {
            if (str_starts_with($key, 'room_') && (int)$value > 0) {
        
                // Determine room type code
                switch ($key) {
                    case 'room_double':
                        $room = 'D';
                        break;
                    case 'room_triple':
                        $room = 'T';
                        break;
                    case 'room_quad':
                        $room = 'Q';
                        break;
                    case 'room_sea_double':
                        $room = 'Deluxe_D';
                        break;
                    case 'room_sea_triple':
                        $room = 'Deluxe_T';
                        break;
                    case 'room_sea_quad':
                        $room = 'Deluxe_Q';
                        break;
                    default:
                        $room = 'Unknown';
                }
        
                for ($i = 1; $i <= (int)$value; $i++) {
                    Room::insert([
                        'check_in' => $request->check_in,
                        'check_out' => $request->check_out,
                        'nights' => $nights,
                        'rooms' => '',
                        'booking_id' => $bookingId,
                        'room_type' => $room
                    ]);
                }
            } else {
                // Determine room type code
                switch ($key) {
                    case 'double':
                        $room = 'D';
                        break;
                    case 'triple':
                        $room = 'T';
                        break;
                    case 'quad':
                        $room = 'Q';
                        break;
                    case 'sea_double':
                        $room = 'Deluxe_D';
                        break;
                    case 'sea_triple':
                        $room = 'Deluxe_T';
                        break;
                    case 'sea_quad':
                        $room = 'Deluxe_Q';
                        break;
                    default:
                        $room = 'Unknown';
                }
        
                for ($i = 1; $i <= (int)$value; $i++) {
                    Room::insert([
                        'check_in' => $request->check_in,
                        'check_out' => $request->check_out,
                        'nights' => $nights,
                        'rooms' => '',
                        'booking_id' => $bookingId,
                        'room_type' => $room
                    ]);
                }
            }
        }
        return response()->json([
            'bookingID' =>$bookingId,
        ]);

    }

}
