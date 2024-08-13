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
        Schema::create('pregnancy_form_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personal_profile_id')->references('id')->on('personal_profiles')->onDelete('restrict')->onUpdate('cascade');
            $table->string('post_partum',);
            $table->string('family_planning', length: 255);
            $table->string('type_of_delivery', length: 255);
            $table->string('lmp', length: 45);
            $table->string('edc', length: 45);
            $table->smallInteger('gp');
            $table->string('status', length: 45)->nullable()->comment('eg. Active, Delivered, Abort, Others')->default('Active');
            $table->smallInteger('archive')->default(0);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pregnancy_form_profiles');
    }
};
