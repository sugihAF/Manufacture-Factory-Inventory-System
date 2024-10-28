<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateSparepartRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sparepart_requests', function (Blueprint $table) {
            // 1. ID in 'SPRT-RQ-001' format
            $table->string('id')->primary();
            // 2. Client_id from clients table (foreign key)
            $table->unsignedBigInteger('distributor_id');
            // 3. Sparepart_id from sparepart table (foreign key)
            $table->string('sparepart_id');
            // 4. Invoice_id (string and nullable)
            $table->string('invoice_id')->nullable();
            // 5. Quantity
            $table->integer('qty');
            // 6. Request_date (timestamp when new data created)
            $table->timestamp('request_date')->useCurrent();
            // 7. Status (enum with default "Submitted")
            $table->enum('status', ['Submitted', 'Confirmed', 'On Progress', 'Ready', 'Done', 'Rejected', 'Pending'])
                  ->default('Submitted');
            // Timestamps (created_at and updated_at)
            $table->timestamps();
            // Foreign Key Constraints
            $table->foreign('distributor_id')->references('id')->on('distributors')->onDelete('cascade');
            $table->foreign('sparepart_id')->references('id')->on('spareparts')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sparepart_requests');
    }
}