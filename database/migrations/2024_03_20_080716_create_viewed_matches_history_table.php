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
        Schema::create('viewed_matches_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('viewed_id');
            $table->string('last_view_date');
            $table->string('last_view_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('viewed_matches_history');
    }
};
