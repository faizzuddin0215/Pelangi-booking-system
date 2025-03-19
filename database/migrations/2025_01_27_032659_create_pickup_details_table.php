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
        Schema::create('pickup_details', function (Blueprint $table) {
            $table->id();
            $table->string('pickup_name', 100)->nullable()->default(0);
            $table->integer('booking_id')->nullable()->default(0);
            $table->integer('pickup_pax')->nullable()->default(0);
            $table->decimal('pickup_rate')->nullable()->default(0.00);
            $table->decimal('total_pickup_rate')->nullable()->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pickup_details');
    }
};
