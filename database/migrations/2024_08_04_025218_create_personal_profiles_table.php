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
        Schema::create('personal_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('lastname', length: 45);
            $table->string('firstname', length: 45);
            $table->string('middlename')->nullable();
            $table->date('birthdate');
            $table->enum('sex', ["Male", "Female"]);
            $table->string('civil_status', length: 45);
            $table->string('educational_attainment', length: 255);
            $table->string('work', length: 255);
            $table->foreignId('family_head_id')->references('id')->on('personal_profiles')->onDelete('restrict')->onUpdate('cascade');
            $table->string('relation_ship_to_head', length: 45);
            $table->string('phone_number', length: 14);
            $table->smallInteger('archive')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_profiles');
    }
};
