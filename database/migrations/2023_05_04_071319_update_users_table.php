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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('phone');
            $table->string('current_job_location');
            $table->unsignedBigInteger('designation_id');
            $table->string('qualification');
            $table->unsignedBigInteger('language_id');
            $table->text('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('current_job_location');
            $table->dropColumn('designation_id');
            $table->dropColumn('qualification');
            $table->dropColumn('description');
        });
    }
};
