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
        Schema::create('income_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('income_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('amount');
            $table->decimal('purchase_price', 8, 2);
            $table->decimal('sale_price', 8, 2);
            $table->timestamps();

            // Define restriction
            $table->foreign('income_id')->references('id')->on('incomes');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('income_detail');
    }
};
