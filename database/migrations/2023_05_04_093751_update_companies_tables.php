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
        Schema::table('companies', function (Blueprint $table) {
            $table->unsignedBigInteger('company_type_id');
            $table->string('email');
            $table->integer('company_size')->nullable();
            $table->string('weblink')->nullable();
            $table->string('cover_photo')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('pinterest')->nullable();
            $table->string('dribble')->nullable();
            $table->string('behance')->nullable();

            $table->foreign('owner')->references('id')->on('users');
            $table->foreign('company_type_id')->references('id')->on('company_types');
            $table->foreign('location_id')->references('id')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('company_type_id');
            $table->dropColumn('email');
            $table->dropColumn('company_size');
            $table->dropColumn('weblink');
            $table->dropColumn('cover_photo');
            $table->dropColumn('facebook');
            $table->dropColumn('twitter');
            $table->dropColumn('linkedin');
            $table->dropColumn('pinterest');
            $table->dropColumn('dribble');
            $table->dropColumn('behance');

            $table->dropForeign(['company_owner']);
            $table->dropForeign(['company_type_id']);
            $table->dropForeign(['location_id']);

        });
    }
};
