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
        Schema::create('orders', function (Blueprint $table) {
          $table->id();

            // User
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Order Info
            $table->string('order_number')->unique();

            // Pricing
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount_percent', 5, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('gst_percent', 5, 2)->default(18);
            $table->decimal('gst_amount', 10, 2)->default(0);
            $table->decimal('grand_total', 10, 2);

            // Payment
            $table->enum('payment_method', ['cod', 'paypal', 'razorpay','stripe'])->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'failed'])
                  ->default('pending');

            // Order Status
            $table->enum('order_status', [
                'pending',
                'confirmed',
                'shipped',
                'delivered',
                'cancelled'
            ])->default('pending');

            // Address snapshot
            $table->string('customer_name');
            $table->string('email');
            $table->string('phone');
            $table->text('address');
            $table->text('pincode');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
