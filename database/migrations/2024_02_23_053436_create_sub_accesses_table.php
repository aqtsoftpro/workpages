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
        Schema::create('sub_accesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('post_for')->default(30);
            $table->enum('allow_ads', ['yes', 'no'])->default('no');
            $table->enum('allow_edits', ['yes', 'no'])->default('no');
            $table->boolean('cv_access')->default(true);
            $table->integer('cv_credit')->default(0)->comment('cv download credits');
            $table->integer('msg_credit')->default(0)->comment('Message credits');
            $table->enum('allow_ref', ['yes', 'no'])->default('no');
            $table->enum('allow_right', ['yes', 'no'])->default('no');
            $table->enum('allow_others', ['yes', 'no'])->default('no')->comment('Message credits');
            $table->enum('h_s_screen', ['yes', 'no'])->default('no')->comment('Health and safety screening');
            $table->enum('allow_interview', ['yes', 'no'])->default('no')->comment('Access to our virtual interview scheduler');
            $table->enum('recruiter_dash', ['yes', 'no'])->default('no')->comment('Acess to our recruiter dashboard');
            $table->enum('casual_portal', ['yes', 'no'])->default('no')->comment('Access to our casual PORTAL');
            $table->enum('rec_support', ['yes', 'no'])->default('no')->comment('Dedicated recruitment support');
            $table->date('expired_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_accesses');
    }
};
