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
        Schema::disableForeignKeyConstraints();

        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id');
            $table->string('voucher_type');
            $table->string('voucher_number');
            $table->dateTime('date');
            $table->decimal('tax', 8, 2); // with 8 digits and 2 decimals
            $table->enum('status', [1, 0])->nullable();
            $table->timestamps();

            // Define restriction
            $table->foreign('provider_id')->references('id')->on('providers');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
