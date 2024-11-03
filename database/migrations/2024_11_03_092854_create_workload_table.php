<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkloadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workloads', function (Blueprint $table) {
            // 1. ID in 'WKLD-001' format
            $table->string('id')->primary();
            // 2. Request_id from sparepart_requests table (foreign key)
            $table->unsignedBigInteger('request_id');
            // 3. Factory_id from factory table (foreign key)
            $table->unsignedBigInteger('factory_id');
            // 4. Start_date set to current timestamp
            $table->timestamp('start_date')->useCurrent();
            // 5. Completion_date nullable
            $table->timestamp('completion_date')->nullable();
            // 6. Status with default 'available'
            $table->enum('status', ['busy', 'available'])->default('available');
            // 7. Supervisor_approval from supervisor table (foreign key)
            $table->unsignedBigInteger('supervisor_approval');
            // Timestamps (created_at and updated_at)
            $table->timestamps();
            // Foreign Key Constraints
            $table->foreign('request_id')->references('id')->on('sparepart_requests')->onDelete('cascade');
            $table->foreign('factory_id')->references('id')->on('factories')->onDelete('cascade');
            $table->foreign('supervisor_approval')->references('id')->on('supervisors')->onDelete('cascade');
            // Indexes for performance
            $table->index('request_id');
            $table->index('factory_id');
            $table->index('supervisor_approval');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workload');
    }
}