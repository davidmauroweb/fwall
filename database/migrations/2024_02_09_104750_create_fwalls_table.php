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
        Schema::create('fwalls', function (Blueprint $table) {
            $table->id();
            $table->dateTime('time', $precision = 6)->unique();
            $table->string('userId',25);
            $table->ipAddress('ipClient');
            $table->string('site', 50);
            $table->string('block', 3);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fwalls');
    }
};
