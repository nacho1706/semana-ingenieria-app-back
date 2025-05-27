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
        Schema::table('equipos', function (Blueprint $table) {
            $table->string('puntos')->nullable()->default('0');
            $table->string('PJ')->nullable()->default('0');
            $table->string('PG')->nullable()->default('0');
            $table->string('PE')->nullable()->default('0');
            $table->string('PP')->nullable()->default('0');
            $table->string('GF')->nullable()->default('0');
            $table->string('DG')->nullable()->default('0');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipos', function (Blueprint $table) {
            $table->dropColumn(['puntos', 'PJ', 'PG', 'PE', 'PP', 'GF', 'DG']);
        });
    }
};
