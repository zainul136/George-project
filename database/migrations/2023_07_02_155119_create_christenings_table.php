<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('christenings', function (Blueprint $table) {
            $table->id('christening_id');
            $table->integer('c_project_id')->nullable();
            $table->string('c_date')->nullable();
            $table->string('c_location')->nullable();
            $table->string('c_church')->nullable();
            $table->string('c_church_time')->nullable();
            $table->string('c_reception')->nullable();
            $table->string('c_reception_time')->nullable();
            $table->string('c_baby_name')->nullable();
            $table->string('c_baby_dob')->nullable();
            $table->string('c_mother_name')->nullable();
            $table->string('c_mother_phone')->nullable();
            $table->string('c_father_name')->nullable();
            $table->string('c_father_phone')->nullable();
            $table->string('c_email')->nullable();
            $table->string('c_zomato_baby')->nullable();
            $table->string('c_zomato_baby_time')->nullable();
            $table->longText('c_details')->nullable();
            $table->integer('c_status')->nullable();
            $table->string('c_code')->nullable();
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
        Schema::dropIfExists('christenings');
    }
};
