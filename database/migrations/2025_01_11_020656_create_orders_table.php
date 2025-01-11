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
            $table->string('productId');
            $table->string('customerId');
            $table->string('sellerId');
            $table->string('commentId')->nullable();
            $table->integer('amount');
            $table->integer('rating_by_user')->nullable();
            $table->integer('quantity')->default(1);
            $table->enum('status',['ordered','processing','out-for-delivery','delivered'])->default('ordered');
            $table->enum('is_active',[0,1])->default(1);
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
