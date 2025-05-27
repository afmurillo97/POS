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

        Schema::table('users', function (Blueprint $table) {

            $table->unsignedBigInteger('role_id')->nullable()->after('name');
            $table->enum('status', [1, 0])->nullable()->after('password');

            // Define restriction
            $table->foreign('role_id')->references('id')->on('roles');

        });
        
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
}; 