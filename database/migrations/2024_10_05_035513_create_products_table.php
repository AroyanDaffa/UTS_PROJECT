<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->integer('stock');
            $table->timestamps();

            /**
             * Added Section
             */
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('category_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
