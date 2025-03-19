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
        Schema::create('optional_code_booking', function (Blueprint $table) {
            $table->id();
            $table->integer('booking_id')->nullable()->default(0);
            $table->string('optional_name', 100)->nullable();
            $table->integer('optional_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('optional_code_booking');
    }
};
