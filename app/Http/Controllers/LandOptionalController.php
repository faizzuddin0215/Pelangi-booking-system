<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Dropoff;
use App\Models\DropoffDetails;
use App\Models\OptionalArrangement;
use App\Models\OptionalArrangementDetails;
use App\Models\OptionalCodeBooking;
use App\Models\Pickup;
use App\Models\PickupDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LandOptionalController extends Controller
{
    public function form3($bookingId, $amendId) {

        return view('form3', compact('bookingId', 'amendId'));
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
                    // Bookings::query()
                    // ->where('booking_id', $request->booking_id)
                    // ->where('amend_id', $request->amendid)
                    // ->update([
                    //     $request->pickup_field   => $request->pickup_name,
                    //     $price_field    => $pickup->pickup_rate    
                    // ]);

                    if ($pickup) {
                        return response()->json([
                            'success' => true,
                            'pickup_method' => $request->pickup_field,
                            'price_field' => $price_field,
                            'pickup_rate' => $pickup->pickup_rate  
                        ]);
                    }
                } else {
                    $find_pickup_details = Bookings::query()
                    ->where('booking_id', $request->booking_id)
                    ->where('amend_id', $request->amendid)
                    ->first();

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
                    // // if ($request->amendid == 0) {
                    //     Bookings::query()
                    //     ->where('booking_id', $request->booking_id)
                    //     ->where('amend_id', $request->amendid)
                    //     ->update([
                    //         $pax_field => $request->pickup_pax_value,
                    //         $total_price_field => $total_rate
                    //     ]);
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
                        // $bookings = Bookings::query()
                        // ->where('booking_id', $request->booking_id)
                        // ->where('amend_id', $request->amendid)
                        // ->update([
                        //     $request->dropoff_field   => $request->dropoff_name,
                        //     $price_field    => $dropoff->dropoff_rate    
                        // ]);
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
                            'success' => true,
                            'dropoff_method' => $request->dropoff_field,
                            'price_field' => $price_field,
                            'dropoff_rate' => $dropoff->dropoff_rate 
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
                        // Bookings::query()
                        // ->where('booking_id', $request->booking_id)
                        // ->where('amend_id', $request->amendid)
                        // ->update([
                        //     $pax_field => $request->dropoff_pax_value,
                        //     $total_price_field => $total_rate
                        // ]);
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
        
                    // DropoffDetails::query()
                    // ->where('id', $request->dropoff_id)
                    // ->update([
                    //     'dropoff_pax' => $request->dropoff_pax_value,
                    //     'total_dropoff_rate' => $total_rate
                    // ]);

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

    public function save(Request $request, $bookingId) {
        $pickupData = $request->input('pickupData');
        $dropoffData = $request->input('dropoffData');
        $optionalData = $request->input('optionalData');

        // Now you can loop or process as needed
        foreach ($pickupData as $index => $pickup) {
            $index++;
            // Guard against division by zero and nulls
            $pax = $pickup['pickup_pax'] ?? 0;
            $total = $pickup['pickup_total'] ?? 0;
            $name = $pickup['pickup_name'] ?? '';
            $pickup_pax = 'pickup0'.$index.'_pax';
            $pickup_price = 'pickup0'.$index.'_price';
            $pickup_total = 'pickup0'.$index.'_total';

            if ($name && $pax > 0) {
                $pickup_rate = $total / $pax;

                Bookings::query()
                ->where('booking_id', $bookingId)
                ->where('amend_id', $request->amendid)
                ->update([
                    $pickup['pickup_name'] => $pickup['pickup_selected'],
                    $pickup_pax => $pickup['pickup_pax'],
                    $pickup_price => $pickup_rate,
                    $pickup_total => $pickup['pickup_total']
                ]);
            }
        }

        foreach ($dropoffData as $index => $dropoff) {
            $index++;
            // Guard against division by zero and nulls
            $pax = $dropoff['dropoff_pax'] ?? 0;
            $total = $dropoff['dropoff_total'] ?? 0;
            $name = $dropoff['dropoff_name'] ?? '';
            $dropoff_pax = 'dropoff0'.$index.'_pax';
            $dropoff_price = 'dropoff0'.$index.'_price';
            $dropoff_total = 'dropoff0'.$index.'_total';

            if ($name && $pax > 0) {
                $dropoff_rate = $total / $pax;

                Bookings::query()
                ->where('booking_id', $bookingId)
                ->where('amend_id', $request->amendid)
                ->update([
                    $dropoff['dropoff_name'] => $dropoff['dropoff_selected'],
                    $dropoff_pax => $dropoff['dropoff_pax'],
                    $dropoff_price => $dropoff_rate,
                    $dropoff_total => $dropoff['dropoff_total']
                ]);
            }
        }

        foreach ($optionalData as $index => $optional) {
            $index++;

            $optional_desc_field = 'optional0'.$index.'_desc';
            $optional_sst_field = 'optional0'.$index.'_gst';
            $optional_code_field = 'optional0'.$index.'_bill_to';
            $optional_pax_field = 'optional0'.$index.'_pax';
            $optional_price_field = 'optional0'.$index.'_price';
            $optional_total_field = 'optional0'.$index.'_total';

            $optional_desc = $optional['optional_selected'];
            $optional_sst = $optional['optional_gst'];
            $optional_code = $optional['optional_code'];
            $optional_pax = $optional['optional_qty'];
            $optional_price = $optional['optional_price'];
            $optional_total = $optional['optional_total'];

            Bookings::query()
                ->where('booking_id', $bookingId)
                ->where('amend_id', $request->amendid)
                ->update([
                    $optional_desc_field => $optional_desc,
                    $optional_sst_field => $optional_sst,
                    $optional_code_field => $optional_code,
                    $optional_pax_field => $optional_pax,
                    $optional_price_field => $optional_price,
                    $optional_total_field => $optional_total,

                ]);
        }

        return response()->json([
            'success' => true
        ]);

    }

    public function getPickupDetailsOther(Request $request) {
        $find_pickup_details = Bookings::query()
        ->where('booking_id', $request->booking_id)
        ->where('amend_id', $request->amendid)
        ->first();

        if ($request->field == 'pickup01_method') {
            $total_price_field = 'pickup01_total';
            $price = $find_pickup_details->pickup01_price;
        } else if ($request->field == 'pickup02_method') {
            $total_price_field = 'pickup02_total';
            $price = $find_pickup_details->pickup02_price;
        } else {
            $total_price_field = 'pickup03_total';
            $price = $find_pickup_details->pickup03_price;
        }
        $total_rate = $request->pickup_pax_value * $price;
        Bookings::query()
        ->where('booking_id', $request->booking_id)
        ->where('amend_id', $request->amendid)
        ->update([
            $request->pickup_field   => $request->pickup_name,
            $total_price_field => $total_rate
        ]);
    }

    public function getDropoffDetailsOther(Request $request) {
        $find_dropoff_details = Bookings::query()
        ->where('booking_id', $request->booking_id)
        ->where('amend_id', $request->amendid)
        ->first();

        if ($request->field == 'dropoff01_method') {
            $total_price_field = 'dropoff01_total';
            $price = $find_dropoff_details->dropoff01_price;
        } else if ($request->field == 'dropoff02_method') {
            $total_price_field = 'dropoff02_total';
            $price = $find_dropoff_details->dropoff02_price;
        } else {
            $total_price_field = 'dropoff03_total';
            $price = $find_dropoff_details->dropoff03_price;
        }
        $total_rate = $request->dropoff_pax_value * $price;
        Bookings::query()
        ->where('booking_id', $request->booking_id)
        ->where('amend_id', $request->amendid)
        ->update([
            $request->dropoff_field   => $request->dropoff_name,
            $total_price_field => $total_rate
        ]);
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

        $optionalData = [
            'optional_field' =>  $price_field,
            'optional_sst'   =>  $optionalDetails->optional_sst,
            'optional_code'  =>  $optionalDetails->optional_code,
            'optional_price' =>  $optionalDetails->optional_rate
        ];
        // Bookings::query()
        // ->where('booking_id', $request->booking_id)
        // ->where('amend_id', $request->amendid)
        // ->update([
        //     $request->optionalField => $request->optional_name,
        //     $price_field            => $optionalDetails->optional_rate,
        //     $optional_sst           => $optionalDetails->optional_sst,

        // ]);

        // OptionalCodeBooking::query()
        // ->updateOrCreate(
        //     [
        //         'optional_id'   =>  $optional_id,
        //     ],
        //     [
        //         'booking_id'    =>  $request->booking_id,
        //         'optional_id'   =>  $optional_id,
        //         'optional_name' =>  $request->optional_name,
        //         'optional_code' =>  $optionalDetails->optional_code
        //     ]
        // );

        // if ($optionalDetails->dive_package == 1) {
        //     Bookings::query()
        //     ->where('booking_id', $request->booking_id)
        //     ->where('amend_id', $request->amendid)
        //     ->update([
        //         'dive_pckg'             =>  $optionalDetails->dive_package
        //     ]);
        // }

        if ($optionalDetails) {
            return response()->json([
                'success' => true,
                'data'  => $optionalData
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

        // Bookings::query()
        // ->where('booking_id', $request->booking_id)
        // ->where('amend_id', $request->amendid)
        // ->update([
        //     $total_field    =>  $total_optional,
        //     $qtyfield       =>  $request->newqtyValue
        // ]);

        return response()->json([
            'success' => true,
            'total_optional' => $total_optional
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


}
