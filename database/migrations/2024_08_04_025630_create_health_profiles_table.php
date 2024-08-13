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
        Schema::create('health_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personal_profile_id')->references('id')->on('personal_profiles')->onDelete('restrict')->onUpdate('cascade');
            $table->string("philhealth_number", length: 45)->nullable();
            $table->string('blood_type', length: 5);
            $table->string('maintenance', length: 255)->nullable();
            $table->smallInteger('height');
            $table->smallInteger('weight');
            $table->float('bmi', precision: 53);
            $table->string('health_status')->nullable();
            $table->smallInteger('archive')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_profiles');
    }
};
