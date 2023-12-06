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
        Schema::create('wedding_engagements', function (Blueprint $table) {
            $table->id('wedding_engagement_id');
            $table->integer('we_project_id')->nullable();
            $table->string('we_date')->nullable();
            $table->string('we_location')->nullable();
            $table->string('we_church')->nullable();
            $table->string('we_church_time')->nullable();
            $table->string('we_xetetisi')->nullable();
            $table->string('we_xetetisi_time')->nullable();
            $table->string('we_reception')->nullable();
            $table->string('we_reception_time')->nullable();
            $table->string('we_groom_name')->nullable();
            $table->string('we_groom_phone')->nullable();
            $table->string('we_bride_name')->nullable();
            $table->string('we_bride_phone')->nullable();
            $table->string('we_email')->nullable();
            $table->string('we_zomato_groom')->nullable();
            $table->string('we_zomato_groom_time')->nullable();
            $table->string('we_zomato_groom_home')->nullable();
            $table->string('we_zomato_groom_info')->nullable();
            $table->string('we_zomato_bride')->nullable();
            $table->string('we_zomato_bride_time')->nullable();
            $table->string('we_zomato_bride_home')->nullable();
            $table->string('we_zomato_bride_info')->nullable();
            $table->longText('we_details')->nullable();
            $table->integer('we_status')->nullable();
            $table->string('code')->nullable();
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
        Schema::dropIfExists('wedding_engagements');
    }
};
