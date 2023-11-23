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
        Schema::create('mrac_arac_download_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mrac_arac_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('mrac_arac_id')->references('id')->on('mrac_arac')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mrac_arac_download_history');
    }
};
