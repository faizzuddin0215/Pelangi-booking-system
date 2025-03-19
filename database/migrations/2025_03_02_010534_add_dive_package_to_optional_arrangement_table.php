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
        Schema::table('optional_arrangement', function (Blueprint $table) {
            $table->integer('dive_package')->nullable()->default(0)->after('optional_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('optional_arrangement', function (Blueprint $table) {
            $table->dropColumn('dive_package');
        });
    }
};
