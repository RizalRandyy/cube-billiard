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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_group_id')->nullable();
            $table->string('payment_status')->default('pending');
            $table->string('midtrans_order_id');
            $table->text('payment_type');
            $table->decimal('amount', 15, 2);
            $table->timestamp('paid_at')->nullable();
            $table->boolean('is_latest')->default(true);
            $table->string('snap_token')->nullable();
            $table->timestamps();

            $table->foreign('booking_group_id')->references('id')->on('booking_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
