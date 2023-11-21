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
        Schema::create('payment_report', function (Blueprint $table) {
            $table->id();
            $table->string('county_fips');
            $table->unsignedBigInteger('user_id');
            $table->string('month_year');
            $table->text('comments')->nullable();
            $table->string('document_path')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_report');
    }
};
