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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sellerId');
            $table->string('description');
            $table->string('categoryId');
            $table->string('subCategoryId');
            $table->text('images');
            $table->integer('price');
            $table->integer('discount');
            $table->integer('platformFee')->default(0);
            $table->integer('views')->default(0);
            $table->integer('number_of_customer_rate')->default(0);
            $table->integer('sum_of_all_rating')->default(0);
            $table->integer('rating')->default(0);
            $table->text('commentId')->nullable();
            $table->enum('is_active',[0,1])->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
