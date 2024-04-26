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
        Schema::create('users_bio', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('step')->unsigned()->default(0);
            $table->bigInteger('user_id')->unsigned();

            //Step 1
            $table->string('religion');
            $table->string('community');
            $table->string('mother_tongue');

            //Step 2
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->enum('live_with_family', ['Yes','No'])->nullable();
            $table->string('marital_status')->nullable();
            $table->string('diet')->nullable();
            $table->string('height')->nullable();
            $table->enum('horoscope_require', ['Yes','No'])->nullable();
            $table->enum('manglik', ['Yes','No'])->nullable();

            //Step 3
            $table->string('highest_qualificatin')->nullable();
            $table->string('company_name')->nullable();
            $table->enum('income_type', ['Yearly','Monthly'])->nullable();
            $table->string('income')->nullable();
            $table->string('position')->nullable();

            //Step 4
            $table->string('cast')->nullable();
            $table->string('sub_cast')->nullable();
            $table->string('family_type')->nullable();
            $table->string('family_status')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('brother')->nullable();
            $table->string('sister')->nullable();
            $table->string('family_living_in')->nullable();
            $table->text('family_bio')->nullable();
            $table->string('family_address')->nullable();
            $table->string('family_contact_no')->nullable();

            //Step 5
            $table->text('about')->nullable();
            $table->string('country_code')->nullable();
            $table->string('mobile_no')->unique()->nullable();

            $table->integer('sexual_orientation')->nullable();
            $table->integer('interest')->nullable();
            $table->integer('ug_digree')->nullable();
            $table->integer('pg_digree')->nullable();
            $table->integer('highest_qualification')->nullable();
            $table->integer('occupation')->nullable();
            $table->string('working_professional')->nullable();
            $table->integer('company_position')->nullable();
            $table->string('hobbies')->nullable();
            $table->string('favorite_music')->nullable();
            $table->string('favorite_books')->nullable();
            $table->string('dress_style')->nullable();
            $table->string('favorite_movies')->nullable();
            $table->string('favorite_sports')->nullable();
            $table->string('cuisine')->nullable();
            $table->string('vacation_destination')->nullable();
            $table->integer('sun_sign')->nullable();
            $table->integer('rashi')->nullable();
            $table->integer('nakshtra')->nullable();

            //Step 7
            $table->enum('document_type', ['1','2','3'])->nullable();
            $table->string('document_number')->nullable();
            $table->string('document')->nullable();

            //Extra
            $table->date('dob')->format('Y-m-d')->nullable();
            $table->string('tob')->nullable();

            // added new
            $table->string('profile_handler')->nullable();
			$table->integer('gotra')->nullable();
			$table->integer('sub_gotra')->nullable();
			$table->string('family_values')->nullable();
			$table->string('mother_occupation')->nullable();
			$table->string('relation_type')->nullable();
			$table->string('ug_collage')->nullable();
			$table->string('pg_collage')->nullable();
			$table->string('drinking_habits')->nullable();
			$table->string('smoking_habits')->nullable();
			$table->string('open_to_pates')->nullable();
			$table->string('own_house')->nullable();
			$table->string('own_car')->nullable();
			$table->string('residentail_status')->nullable();
			$table->string('languages')->nullable();
			$table->string('blood_group')->nullable();
			$table->string('hiv')->nullable();
			$table->string('thallassemia')->nullable();
			$table->string('challenged')->nullable();
			$table->string('place_of_birth')->nullable();
			$table->string('tv_shows')->nullable();
			$table->string('food_i_cook')->nullable();
			$table->integer('horoscope_privacy')->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_bio');
    }
};
