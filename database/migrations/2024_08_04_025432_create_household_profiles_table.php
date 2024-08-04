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
        Schema::create('household_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')->references('id')->on('personal_profiles')->onDelete('restrict')->onUpdate('cascade');
            $table->string("household_number")->nullable();
            $table->string("nhts", length: 255);
            $table->string("electricity", length: 45);
            $table->string("water_supply", length: 45);
            $table->string("toilet", length: 45);
            $table->smallInteger('archive')->default('0');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('household_profiles');
    }
};
