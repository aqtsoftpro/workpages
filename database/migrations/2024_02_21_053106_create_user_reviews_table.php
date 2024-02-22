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
        // Schema::create('user_reviews', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('user_id')->constrained()->onDelete('cascade');
        //     $table->foreignId('company_id')->nullable()->constrained()->onDelete('set null');
        //     $table->text('review')->nullable();
        //     $table->tinyInteger('rating')->nullable();
        //     $table->boolean('status')->default(true);
        //     $table->timestamps();
        // });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string('receipt_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_reviews');
    }
};
