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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description');
            $table->integer('organizer_id');
            $table->integer('type_id');
            $table->integer('genre_id');
            $table->integer('sub_genre_id');
            $table->integer('location_id');
            $table->dateTime('event_start_date');
            $table->dateTime('event_end_date');
            $table->dateTime('ticket_book_start_date');
            $table->dateTime('ticket_book_end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
