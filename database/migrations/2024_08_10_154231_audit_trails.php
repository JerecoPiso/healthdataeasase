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
        Schema::create('audit_trails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->default(0);
            $table->integer('reference_id')->default(0);
            $table->string('reference_table', length: 255)->nullable();
            $table->string('action', length: 45);
            $table->string('status', length: 10);
            $table->string('message', length: 255)->nullable();
            $table->text('data')->nullable()->comment('new data/first data');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('audit_trails');
    }
};
