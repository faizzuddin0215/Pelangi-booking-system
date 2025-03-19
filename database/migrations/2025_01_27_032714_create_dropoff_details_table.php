<?php

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
        Schema::create('dropoff_details', function (Blueprint $table) {
            $table->id();
            $table->string('dropoff_name', 100)->nullable()->default(0);
            $table->integer('booking_id')->nullable()->default(0);
            $table->integer('dropoff_pax')->nullable()->default(0);
            $table->decimal('dropoff_rate')->nullable()->default(0.00);
            $table->decimal('total_dropoff_rate')->nullable()->default(0.00);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dropoff_details');
    }
};
