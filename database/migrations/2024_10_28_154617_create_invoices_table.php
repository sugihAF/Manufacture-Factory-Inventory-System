<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::create('invoices', function (Blueprint $table) {
            // 1. ID in 'INVC-001' format
            $table->string('id')->primary();

            // 2. Distributor_id from distributors table (foreign key)
            $table->unsignedBigInteger('distributor_id');

            // 3. Request_id from sparepart_requests table (foreign key)
            $table->string('request_id');

            // 4. Total_amount calculated
            $table->decimal('total_amount', 10, 2);

            // 5. Invoice_date set to current timestamp
            $table->timestamp('invoice_date')->useCurrent();

            // 6. Payment_date nullable
            $table->timestamp('payment_date')->nullable();

            // 7. Status with default 'Pending'
            $table->enum('status', ['Pending', 'Paid', 'Failed'])->default('Pending');

            // 8. Due_date set to one week after invoice_date
            $table->timestamp('due_date');

            // Timestamps (created_at and updated_at)
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('distributor_id')->references('id')->on('distributors')->onDelete('cascade');
            $table->foreign('request_id')->references('id')->on('sparepart_requests')->onDelete('cascade');

            // Indexes for performance
            $table->index('distributor_id');
            $table->index('request_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
