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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->date('departure_date');
            $table->date('return_date');

            // Pricing sesuai ERD
            $table->decimal('price_quad', 15, 2);
            $table->decimal('price_triple', 15, 2);
            $table->decimal('price_double', 15, 2);

            $table->integer('quota');
            $table->integer('available_seats');

            $table->string('airline');
            $table->string('hotel_makkah');
            $table->string('hotel_madinah');

            $table->enum('status', ['draft', 'published', 'closed'])->default('draft');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
