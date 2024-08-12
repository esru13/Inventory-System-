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
            $table->unsignedBigInteger('business_owner_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->decimal('price',8,2);
            $table->integer('stock_quantity');
            $table->timestamps();

            $table->foreign('business_owner_id')
                    ->references('id')  
                    ->on('business_owners')
                    ->onDelete('cascade');
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
