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

        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->string('voucher_type');
            $table->string('voucher_number');
            $table->dateTime('date');
            $table->decimal('tax', 4, 2); // with 4 digits and 2 decimals
            $table->decimal('total', 11, 2);
            $table->enum('status', [1, 0])->nullable();
            $table->timestamps();

            // Define restriction
            $table->foreign('client_id')->references('id')->on('clients');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('sales');
        Schema::enableForeignKeyConstraints();
    }
};
