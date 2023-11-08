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
            $table->date('date');
            $table->string('country');
            $table->string('user');
            $table->string('comments')->nullable();
            $table->string('original_name');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('w9_upload');
    }
}