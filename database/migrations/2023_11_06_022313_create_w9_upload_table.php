<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateW9UploadTable extends Migration
{
    public function up()
    {
        Schema::create('w9_upload', function (Blueprint $table) {
            $table->id();
            $table->string('comments', 150)->nullable();
            $table->string('w9_county_fips');
            $table->unsignedBigInteger('user_id'); 
            // $table->foreign('')->references('id')->on('users'); 
            $table->string('original_name');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('w9_upload');
    }
}