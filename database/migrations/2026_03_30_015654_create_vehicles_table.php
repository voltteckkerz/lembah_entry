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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id('vehicle_id');
            $table->string('plate_number', 20)->nullable();
            $table->string('vehicle_type', 50)->nullable();
            $table->enum('owner_type', ['staff', 'visitor'])->nullable();
            $table->foreignId('visit_id')->nullable()->constrained('visits', 'visit_id')->onDelete('cascade');
            $table->foreignId('attendance_id')->nullable()->constrained('attendances', 'attendance_id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
