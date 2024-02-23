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
            $table->enum('post_for', [15, 30, 45, 60, 90])->default(30);
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
        });

        Schema::table('job_ads', function (Blueprint $table) {
            $table->string('title')->nullable()->after('job_id');
            $table->foreignId('category_id')->nullable()->constrained('job_categories')->onDelete('set null')->after('subscription_id');
            $table->longText('description')->nullable()->after('ends_at');
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
