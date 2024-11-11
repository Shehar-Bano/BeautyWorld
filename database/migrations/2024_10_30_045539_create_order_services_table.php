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
        Schema::create('order_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references("id")->on('orders')->cascadeOnDelete();
             // Service ID column, set as nullable
             $table->unsignedBigInteger('service_id')->nullable();
             $table->foreign('service_id')->references('id')->on('services')->cascadeOnDelete()->cascadeOnUpdate();
             
             // Deal ID column, set as nullable
             $table->unsignedBigInteger('deal_id')->nullable();
             $table->foreign('deal_id')->references('id')->on('deals')->cascadeOnDelete()->cascadeOnUpdate();
             
             $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references("id")->on('users')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_services');
    }
};
