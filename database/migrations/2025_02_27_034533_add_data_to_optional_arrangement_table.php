<?php

use App\Models\Dropoff;
use App\Models\OptionalArrangement;
use App\Models\Pickup;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('optional_arrangement', function (Blueprint $table) {
            OptionalArrangement::query()
            ->insert([
                [
                    'optional_name' => 'Top-up Open Water Course',
                    'optional_code'  => 'OWC',
                    'optional_sst' => 1,
                    'optional_rate' => 1300.00,
                ],
                [
                    'optional_name' => 'Top-up Advance Open Water Course',
                    'optional_code'  => 'AOW',
                    'optional_sst' => 1,
                    'optional_rate' => 1200.00
                ],
                [
                    'optional_name' => 'Top-up Rescue Diver Course',
                    'optional_code'  => 'RDC',
                    'optional_sst' => 1,
                    'optional_rate' => 1200.00
                ],
                [
                    'optional_name' => 'Top-up Emergency First Response',
                    'optional_code'  => 'EFR',
                    'optional_sst' => 1,
                    'optional_rate' => 400.00
                ],
                [
                    'optional_name' => 'Top-up 3D/2N Dive Package (3 Boat Dives, 1 Shore Dive)',
                    'optional_code'  => 'DP3D',
                    'optional_sst' => 1,
                    'optional_rate' => 360.00
                ],
                [
                    'optional_name' => 'Top-up 4D/3N Dive Package (6 Boat Dives, 1 Shore Dive)',
                    'optional_code'  => 'DP4D',
                    'optional_sst' => 1,
                    'optional_rate' => 660.00
                ],
                [
                    'optional_name' => 'Refresher Courese',
                    'optional_code'  => '',
                    'optional_sst' => 1,
                    'optional_rate' => 320.00
                ],
                [
                    'optional_name' => 'Discovery Scuba Diving (DSD)',
                    'optional_code'  => 'DSD',
                    'optional_sst' => 1,
                    'optional_rate' => 220.00
                ],
                [
                    'optional_name' => 'Dive Master Trainee',
                    'optional_code'  => 'DMT',
                    'optional_sst' => 1,
                    'optional_rate' => 0.00
                ],
                [
                    'optional_name' => 'Free Diver',
                    'optional_code'  => 'FD',
                    'optional_sst' => 1,
                    'optional_rate' => 0.00
                ],
                [
                    'optional_name' => 'Instructor at other Resort',
                    'optional_code'  => 'INST',
                    'optional_sst' => 1,
                    'optional_rate' => 0.00
                ],
                [
                    'optional_name' => 'Disbursement - Bus Ticket From ** to ** , **date**, **time**',
                    'optional_code'  => 'Bus',
                    'optional_sst' => 0,
                    'optional_rate' => 50.00
                ],
                [
                    'optional_name' => 'Public Ferry (Adult), **date**, **time**',
                    'optional_code'  => 'PF(A)',
                    'optional_sst' => 1,
                    'optional_rate' => 55.00
                ],
                [
                    'optional_name' => 'Public Ferry (Child), **date**, **time**',
                    'optional_code'  => 'PF(C)',
                    'optional_sst' => 1,
                    'optional_rate' => 35.00
                ],
                [
                    'optional_name' => 'Snorkelling Equipment Hire',
                    'optional_code'  => 'EQ',
                    'optional_sst' => 1,
                    'optional_rate' => 10.00
                ],
                [
                    'optional_name' => 'Life Jacket Hire',
                    'optional_code'  => 'LJ',
                    'optional_sst' => 1,
                    'optional_rate' => 10.00
                ],
                [
                    'optional_name' => 'Marine Park Conservation Fee (Adult)',
                    'optional_code'  => 'MP(A)',
                    'optional_sst' => 0,
                    'optional_rate' => 5.00
                ],
                [
                    'optional_name' => 'Marine Park Conservation Fee (Child)',
                    'optional_code'  => 'MP(C)',
                    'optional_sst' => 0,
                    'optional_rate' => 2.00
                ],
                [
                    'optional_name' => 'Merang Jetty Fees',
                    'optional_code'  => 'MJ',
                    'optional_sst' => 0,
                    'optional_rate' => 0.00
                ],
                [
                    'optional_name' => 'Domestic Travel Insurance',
                    'optional_code'  => 'Ins',
                    'optional_sst' => 1,
                    'optional_rate' => 25.00
                ],
                [
                    'optional_name' => 'Redang - Perhentian - Lang Tengah Day Trip',
                    'optional_code'  => 'DT',
                    'optional_sst' => 1,
                    'optional_rate' => 120.00
                ],
                [
                    'optional_name' => 'Town Tour',
                    'optional_code'  => 'TT',
                    'optional_sst' => 1,
                    'optional_rate' => 30.00
                ],
                [
                    'optional_name' => 'Tourism Tax (TTX)',
                    'optional_code'  => 'TTX',
                    'optional_sst' => 0,
                    'optional_rate' => 30.00
                ],
                [
                    'optional_name' => 'Service Charge',
                    'optional_code'  => '',
                    'optional_sst' => 1,
                    'optional_rate' => 0.00
                ],
                [
                    'optional_name' => 'Lunch',
                    'optional_code'  => '',
                    'optional_sst' => 1,
                    'optional_rate' => 0.00
                ],
                [
                    'optional_name' => 'Dinner',
                    'optional_code'  => '',
                    'optional_sst' => 1,
                    'optional_rate' => 0.00
                ],
                [
                    'optional_name' => 'BBQ Dinner',
                    'optional_code'  => '',
                    'optional_sst' => 1,
                    'optional_rate' => 0.00
                ],
                [
                    'optional_name' => 'Power Mask Hire',
                    'optional_code'  => 'EQP',
                    'optional_sst' => 1,
                    'optional_rate' => 25.00
                ],
                [
                    'optional_name' => 'Room & Breakfast',
                    'optional_code'  => 'EQP',
                    'optional_sst' => 1,
                    'optional_rate' => 0.00
                ],
                [
                    'optional_name' => 'Cancellation Charges',
                    'optional_code'  => 'CNX',
                    'optional_sst' => 0,
                    'optional_rate' => 200.00
                ]
            ]);

            Dropoff::query()
            ->insert([
                ['dropoff_name' => 'Not Decided', 'dropoff_rate' => '0'],
                ['dropoff_name' => 'KT Dropoff', 'dropoff_rate' => '15'],
                ['dropoff_name' => 'Airport Dropoff', 'dropoff_rate' => '15'],
                ['dropoff_name' => 'Bus Dropoff', 'dropoff_rate' => '15'],
                ['dropoff_name' => 'Agent Arranged', 'dropoff_rate' => '0'],
                ['dropoff_name' => 'Own Arrangement', 'dropoff_rate' => '0'],
                ['dropoff_name' => 'Not Required', 'dropoff_rate' => '0'],
                ['dropoff_name' => '07:30AM - Flight AK 6223', 'dropoff_rate' => '15'],
                ['dropoff_name' => '08:40AM - Flight AK 6225', 'dropoff_rate' => '15'],
                ['dropoff_name' => '08:40AM - Flight FY 1257', 'dropoff_rate' => '15'],
                ['dropoff_name' => '08:50AM - Flight MH 1327', 'dropoff_rate' => '15'],
                ['dropoff_name' => '11:00AM - Merang Bus', 'dropoff_rate' => '0'],
                ['dropoff_name' => '11:45AM - Flight OD 1805', 'dropoff_rate' => '15'],
                ['dropoff_name' => '12:00PM - Merang Self Drive', 'dropoff_rate' => '0'],
                ['dropoff_name' => '01:00PM - Bus Station', 'dropoff_rate' => '15'],
                ['dropoff_name' => '01:25PM - Flight AK 6229', 'dropoff_rate' => '15'],
                ['dropoff_name' => '02:20PM - Flight FY 1259', 'dropoff_rate' => '15'],
                ['dropoff_name' => '04:00PM - Flight MH 1335', 'dropoff_rate' => '15'],
                ['dropoff_name' => '05:00PM - Flight AK 6227', 'dropoff_rate' => '15'],
                ['dropoff_name' => '05:15PM - Flight OD 1813', 'dropoff_rate' => '15'],
                ['dropoff_name' => '05:50PM - Flight FY 1261', 'dropoff_rate' => '15'],
                ['dropoff_name' => '07:55PM - Flight MH 1339', 'dropoff_rate' => '15'],
                ['dropoff_name' => '08:35PM - Flight OD 1801', 'dropoff_rate' => '15'],
                ['dropoff_name' => '08:55AM - Flight OD 1815', 'dropoff_rate' => '15'],
                ['dropoff_name' => '09:05PM - Flight FY 1263', 'dropoff_rate' => '15'],
                ['dropoff_name' => '09:25PM - Flight AK 6221', 'dropoff_rate' => '15']
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('optional_arrangement', function (Blueprint $table) {
            //
        });
    }
};
