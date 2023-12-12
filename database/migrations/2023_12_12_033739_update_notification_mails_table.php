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
        Schema::table('notification_mails', function (Blueprint $table) {
            $table->string('name_form')->unique()->change();
            $table->string('subject', 255)->change();
            $table->text('body')->change();
            $table->string('button_title', 100)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notification_mails', function (Blueprint $table) {
            $table->string('name_form')->change();
            $table->string('subject')->change();
            $table->text('body')->change();
            $table->string('button_title')->change();
        });
    }
};
