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
        Schema::table('sub_accesses', function (Blueprint $table) {
            $table->enum('edit_title', ['yes', 'no'])->default('no');
            $table->enum('edit_categ', ['yes', 'no'])->default('no');
            $table->enum('edit_body', ['yes', 'no'])->default('no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_accesses', function (Blueprint $table) {
            //
        });
    }
};
