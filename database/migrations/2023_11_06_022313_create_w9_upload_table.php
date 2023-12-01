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
            $table->string('original_name');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('w9_upload');
    }
}