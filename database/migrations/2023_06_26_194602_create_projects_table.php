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
        Schema::create('projects', function (Blueprint $table) {
            $table->id('project_id');
            $table->string('name')->nullable();
            $table->string('cost')->nullable();
            $table->enum('payment_type', ['cash', 'credit_card', 'bank_transfer'])->default('cash');
            $table->string('project_date')->nullable();
            $table->longText('employees')->nullable();
            $table->longText('contractors')->nullable();
            $table->string('type')->nullable();
            $table->string('client')->nullable();
            $table->string('company')->nullable();
            $table->longText('project_details')->nullable();
            $table->enum('status', ['pending', 'offer', 'pending_approve', 'confirmed', 'invitation_pending', 'ready', 'pending_pay', 'completed'])->nullable();
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
        Schema::dropIfExists('projects');
    }
};
