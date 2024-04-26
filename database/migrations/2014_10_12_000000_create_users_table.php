<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
			$table->string('first_name');
            $table->string('last_name');
            
            $table->string('email')->unique()->nullable();
			$table->string('country_code')->nullable()->default('+91');
            $table->string('phone_number')->unique()->nullable();
			$table->string('profile_image')->nullable();
			$table->enum('profile_for',['Self','Son','Daughter','Relative/Friend','Sister','Brother','Client-Marriage-Bureau'])->default('Self');
			$table->string('cover_image')->nullable();
			$table->enum('is_subscribed',['Yes','No'])->default('No');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('user_type');
			$table->enum('gender', ['Male','Female','Other'])->nullable();
			$table->date('dob')->nullable();
			$table->tinyInteger('noti_via_nitification')->default('1');
            $table->tinyInteger('noti_via_email')->default('1');
            $table->enum('status',['active','inactive','pending','blocked'])->default('pending');
			$table->tinyInteger('is_approved')->default('0');
			$table->tinyInteger('step_complete')->default('0');
            $table->rememberToken();
			$table->integer('live_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}