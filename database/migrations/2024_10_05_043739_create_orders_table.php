<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Jalankan migrasi.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();  // Order ID (primary key)
            /**
             * Disabled, using primary / foreign key as identifier instead
             */
            // $table->string('customer_name');  // Nama pelanggan
            $table->decimal('total', 15, 2);  // Total pesanan (dalam format desimal) -- flag :: kenapa decimal ?
            $table->date('date');  // Tanggal pesanan
            $table->timestamps();  // created_at dan updated_at

            /**
             * Added Section
             */
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('product_name');
            $table->string('destination_address');
        });
    }

    /**
     * Batalkan migrasi.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
