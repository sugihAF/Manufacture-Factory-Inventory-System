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
        Schema::create('machines', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->unsignedBigInteger('factory_id');
            $table->string('name');
            $table->string('status')->default('Available');
            // Add other machine-specific columns as needed
            $table->timestamps();
    
            // Foreign Key Constraint
            $table->foreign('factory_id')->references('id')->on('factories')->onDelete('cascade');
    
            // Index for performance
            $table->index('factory_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machines');
    }
};
