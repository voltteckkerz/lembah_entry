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
        Schema::table('visits', function (Blueprint $table) {
            $table->dropColumn(['guard_signature', 'visitor_signature', 'host_signature', 'supervisor_signature']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->longText('guard_signature')->nullable();
            $table->longText('visitor_signature')->nullable();
            $table->longText('host_signature')->nullable();
            $table->longText('supervisor_signature')->nullable();
        });
    }
};
