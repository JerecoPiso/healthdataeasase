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
        Schema::create('puroks', function (Blueprint $table) {
            $table->id();
            $table->string('name', length: 255);
            $table->smallInteger('archive')->default(0);
            $table->timestamps();
        });
        Schema::create('household_profiles', function (Blueprint $table) {
            $table->id();
            // household head
            $table->bigInteger('personal_profile_id');
            $table->string("household_number")->nullable();
            $table->foreignId('bhw_user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('purok_id')->references('id')->on('puroks')->onDelete('restrict')->onUpdate('cascade');

            $table->string("nhts", length: 255);
            $table->string("electricity", length: 45);
            $table->string("water_supply", length: 45);
            $table->string("toilet", length: 45);
            $table->smallInteger('archive')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   
        Schema::dropIfExists('puroks');

        Schema::dropIfExists('household_profiles');
    }
};
