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
        Schema::create('contructor_payment_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contractor_id');
            $table->unsignedBigInteger('project_id');
            $table->string('payment')->nullable();
            $table->date('date')->nullable();
            $table->string('remaining_payment')->nullable();
            $table->enum('payment_type', ['cash', 'cheque', 'bank_transfer'])->default('cash');
            $table->longText('message')->nullable();
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
        Schema::dropIfExists('contructor_payment_logs');
    }
};
