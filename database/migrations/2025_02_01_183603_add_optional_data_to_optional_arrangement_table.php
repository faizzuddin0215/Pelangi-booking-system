<?php

use App\Models\OptionalArrangement;
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
                    'optional_rate' => 1300.00,
                ],
                [
                    'optional_name' => 'Top-up Advance Open Water Course',
                    'optional_rate' => 1200.00
                ],
                [
                    'optional_name' => 'Top-up Rescue Diver Course',
                    'optional_rate' => 1200.00
                ],
                [
                    'optional_name' => 'Top-up Emergency First Response',
                    'optional_rate' => 400.00
                ],
                [
                    'optional_name' => 'Top-up 3D/2N Dive Package (3 Boat Dives, 1 Shore Dive)',
                    'optional_rate' => 360.00
                ],
                [
                    'optional_name' => 'Top-up 4D/3N Dive Package (6 Boat Dives, 1 Shore Dive)',
                    'optional_rate' => 660.00
                ],
                [
                    'optional_name' => 'Refresher Courese',
                    'optional_rate' => 320.00
                ],
                [
                    'optional_name' => 'Discovery Scuba Diving (DSD)',
                    'optional_rate' => 220.00
                ],
                [
                    'optional_name' => 'Dive Master Trainee',
                    'optional_rate' => 0.00
                ],
                [
                    'optional_name' => 'Free Diver',
                    'optional_rate' => 0.00
                ],
                [
                    'optional_name' => 'Instructor at other Resort',
                    'optional_rate' => 0.00
                ],
                [
                    'optional_name' => 'Disbursement - Bus Ticket From ** to ** , **date**, **time**',
                    'optional_rate' => 50.00
                ],
                [
                    'optional_name' => 'Public Ferry (Adult), **date**, **time**',
                    'optional_rate' => 55.00
                ],
                [
                    'optional_name' => 'Public Ferry (Child), **date**, **time**',
                    'optional_rate' => 35.00
                ],
                [
                    'optional_name' => 'Snorkelling Equipment Hire',
                    'optional_rate' => 10.00
                ],
                [
                    'optional_name' => 'Life Jacket Hire',
                    'optional_rate' => 10.00
                ],
                [
                    'optional_name' => 'Marine Park Conservation Fee (Adult)',
                    'optional_rate' => 5.00
                ],
                [
                    'optional_name' => 'Marine Park Conservation Fee (Child)',
                    'optional_rate' => 2.00
                ],
                [
                    'optional_name' => 'Merang Jetty Fees',
                    'optional_rate' => 0.00
                ],
                [
                    'optional_name' => 'Domestic Travel Insurance',
                    'optional_rate' => 25.00
                ]
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
