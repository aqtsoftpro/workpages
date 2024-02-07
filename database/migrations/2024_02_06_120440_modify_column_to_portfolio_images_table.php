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
        Schema::table('portfolio_images', function (Blueprint $table) {
            $table->dropForeign('portfolio_images_portfolio_id_foreign');
            $table->dropColumn('portfolio_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('portfolio_images', function (Blueprint $table) {
            //
        });
    }
};
