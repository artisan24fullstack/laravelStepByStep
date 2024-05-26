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
        Schema::create('hikes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('distance', 8, 2);
            $table->integer('duration'); // Assuming duration is in minutes
            $table->integer('elevation_gain');
            $table->text('description')->nullable(); // Optional description field
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hikes');
    }
};
