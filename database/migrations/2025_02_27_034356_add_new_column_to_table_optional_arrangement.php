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
        Schema::table('table_optional_arrangement', function (Blueprint $table) {
            Schema::table('optional_arrangement', function (Blueprint $table) {
                $table->string('optional_code', 100)->nullable()->after('optional_name');
                $table->integer('optional_sst')->nullable()->after('optional_name');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('table_optional_arrangement', function (Blueprint $table) {
            $table->dropColumn('optional_code');
            $table->dropColumn('optional_sst');
        });
    }
};
