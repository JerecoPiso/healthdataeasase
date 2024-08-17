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
        //
        Schema::create('vitals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('personal_profile_id')->references('id')->on('personal_profiles')->onDelete('restrict')->onUpdate('cascade');
            $table->string('blood_pressure', length:15)->nullable();
            $table->decimal('temperature', 2, 2);
            $table->integer('pulse');
            $table->integer('respiration');
            $table->smallInteger('archive', 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('vitals');

    }
};
