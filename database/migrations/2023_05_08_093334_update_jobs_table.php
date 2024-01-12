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
        Schema::table('jobs', function (Blueprint $table) {
            $table->string('job_title');
            $table->string('expiration')->nullable();
            $table->unsignedBigInteger('job_type_id');
            $table->integer('vacancy')->nullable();
            $table->integer('experience')->nullable;
            $table->unsignedBigInteger('qualification_id')->nullable();
            $table->string('gender');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            //
        });
    }
};
