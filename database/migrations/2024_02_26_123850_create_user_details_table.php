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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('active_job')->nullable();
            $table->foreignId('country_id')->nullable()->constrained('locations')->onDelete('cascade');
            $table->enum('profile_status', ['opened', 'closed'])->default('closed');
            $table->enum('is_available', ['yes', 'no'])->default('no');
            $table->string('intro_video')->nullable()->comment('max 60 minutes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
