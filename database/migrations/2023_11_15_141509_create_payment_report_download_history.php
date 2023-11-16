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
        Schema::create('payment_report_download_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_report_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('payment_report_id')->references('id')->on('payment_report')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_report_download_history');
    }
};
