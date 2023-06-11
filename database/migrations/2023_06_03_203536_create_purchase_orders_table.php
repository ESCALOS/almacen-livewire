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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained();
            $table->foreignId('currency_id')->constrained();
            $table->enum('payment_method',['CREDITO','CONTADO']);
            $table->boolean('cleared')->default(false);
            $table->enum('state',['PENDIENTE','INCOMPLETA','COMPLETA','ANULADA']);
            $table->decimal('amount',10,2,true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
