<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained()->cascadeOnDelete();
            $table->string('buyer_name');
            $table->string('buyer_phone');
            $table->integer('quantity_ordered');
            $table->decimal('total_amount', 12, 2);
            $table->decimal('platform_fee', 12, 2);
            $table->decimal('farmer_net_payout', 12, 2);
            $table->string('pickup_method');
            $table->string('pickup_otp', 6);
            $table->string('status')->default('PENDING');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};