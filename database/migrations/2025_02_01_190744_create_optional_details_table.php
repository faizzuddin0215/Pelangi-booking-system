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
        Schema::create('optional_arrangement_details', function (Blueprint $table) {
            $table->id();
            $table->string('optional_desc', 100)->nullable();
            $table->integer('booking_id')->nullable()->default(0);
            $table->integer('optional_sst')->nullable()->default(1);
            $table->string('optional_code')->nullable();
            $table->integer('optional_qty')->nullable()->default(0);
            $table->decimal('optional_price')->nullable()->default(0.00);
            $table->decimal('optional_total')->nullable()->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('optional_arrangement_details');
    }
};
