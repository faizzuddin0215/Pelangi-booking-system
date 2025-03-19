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
        Schema::table('bookings_amend', function (Blueprint $table) {
            $table->integer('amend')->nullable()->default(0)->after('amend_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings_amend', function (Blueprint $table) {
            $table->dropColumn('amend');
        });
    }
};
