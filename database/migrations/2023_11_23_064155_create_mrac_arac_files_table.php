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
        Schema::create('mrac_arac_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mrac_arac_id');
            $table->string('file_path');
            $table->timestamps();

            $table->foreign('mrac_arac_id')->references('id')->on('mrac_arac')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mrac_arac_files');
    }
};
