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
        Schema::table('packages', function (Blueprint $table) {
            $table->enum('pause_ad', ['yes', 'no'])->default('no')->comment('Dedicated recruitment support');
            $table->enum('delete_ad', ['yes', 'no'])->default('no')->comment('Dedicated recruitment support');
            $table->enum('close_ad', ['yes', 'no'])->default('no')->comment('Dedicated recruitment support');
            $table->enum('edit_title', ['yes', 'no'])->default('no')->comment('Dedicated recruitment support');
            $table->enum('edit_categ', ['yes', 'no'])->default('no')->comment('Dedicated recruitment support');
            $table->enum('edit_body', ['yes', 'no'])->default('no')->comment('Dedicated recruitment support');
        });

        Schema::table('job_ads', function (Blueprint $table) {
            $table->enum('ad_status', ['running', 'paused', 'closed'])->default('running')->comment('Check job ad status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            //
        });
    }
};
