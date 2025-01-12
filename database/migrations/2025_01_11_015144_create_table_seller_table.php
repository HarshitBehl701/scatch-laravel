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
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->string('brandLogo')->nullable();
            $table->string('name');
            $table->string('brandName');
            $table->string('email');
            $table->string('password');
            $table->string('contact')->nullable();
            $table->text('address')->nullable();
            $table->text('productId')->nullable();
            $table->string('gstin')->nullable();
            $table->enum('is_active',[0,1])->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
