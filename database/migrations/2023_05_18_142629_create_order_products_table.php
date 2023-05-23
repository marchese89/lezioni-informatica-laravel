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
        Schema::create('order_products', function (Blueprint $table) {
            $table->integer('id_ordine');
            $table->integer('id_prodotto');
            $table->integer('tipo_prodotto');
            $table->integer('price')->nullable();
            $table->primary(['id_ordine', 'id_prodotto', 'tipo_prodotto']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_products');
    }
};
