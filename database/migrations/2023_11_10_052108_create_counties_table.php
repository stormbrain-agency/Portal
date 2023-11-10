<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('counties', function (Blueprint $table) {
            $table->id();
            $table->string('county');
            $table->string('county_ascii');
            $table->string('county_full');
            $table->string('county_fips');
            $table->string('state_id');
            $table->string('state_name');
            $table->float('lat');
            $table->float('lng');
            $table->integer('population');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counties');
    }
};
