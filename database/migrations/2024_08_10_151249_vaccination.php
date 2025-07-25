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
        Schema::create('vaccines', function (Blueprint $table) {
            $table->id();
            $table->string('name', length: 255);
            $table->smallInteger('archive', 0);
            $table->timestamps();
        });
        Schema::create('vaccinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personal_profile_id')->references('id')->on('personal_profiles')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('vaccine_id')->references('id')->on('vaccines')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('vaccinator_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            // $table->string('vaccine', length: 255);
            // $table->string('vaccinator', length: 255);
            $table->smallInteger('dose')->default(0);
            $table->timestamp('vaccination_datetime', precision: 0);
            $table->text('remarks')->nullable();
            $table->smallInteger('archive')->default(0);

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('vaccines');
        Schema::dropIfExists('vaccinations');
    }
};
