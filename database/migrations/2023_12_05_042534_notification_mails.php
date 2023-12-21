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
        Schema::create('notification_mails', function (Blueprint $table) {
            $table->id();
            $table->enum('name_form', ['mRec/aRec Admin', 'mRec/aRec User', 'Payment Report Admin', 'Payment Report User', 'Register Email', 'Reset Password Mail', 'Verify Email', 'W9 Email Admin', 'W9 Email User', 'Welcome County Email'])->default('mRec/aRec Admin');
            $table->text('subject');
            $table->text('body');
            $table->string('button_title');
            $table->timestamps();
          });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_mails');
    }
};
