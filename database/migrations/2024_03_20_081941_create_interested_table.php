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
        Schema::create('interested', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('person_id');
            $table->enum('status',['accept','reject','pending','blocked'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interested');
    }
};
