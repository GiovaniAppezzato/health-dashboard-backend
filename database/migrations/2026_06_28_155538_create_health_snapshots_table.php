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
        Schema::create('health_snapshots', function (Blueprint $table) {
            $table->id();
            $table->decimal('sleep_hours', 4, 2);
            $table->unsignedSmallInteger('glucose_level');
            $table->unsignedSmallInteger('heart_rate');
            $table->decimal('water_intake', 4, 2);
            $table->date('measured_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_snapshots');
    }
};
