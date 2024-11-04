<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingsTable extends Migration
{
    /**
     * Jalankan migrasi.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();  // Order ID (primary key)
            $table->string('customer_name');  // Nama pelanggan
            $table->string('shipping_status');  // Status pengiriman (contoh: In Transit, Delivered, etc.)
            $table->string('shipping_current_location'); // shipping_current_location
            $table->string('address');  // Alamat pengiriman
            $table->timestamps();  // Timestamps untuk created_at dan updated_at
        });
    }

    /**
     * Batalkan migrasi.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shippings');
    }
}
