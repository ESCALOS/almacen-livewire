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
        Schema::create('requirement_new_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requirement_id')->constrained();
            $table->string('product_name');
            $table->text('description');
            $table->decimal('quantity',10,2,true);
            $table->text('reason');
            $table->foreignId('measurement_unit_id')->constrained();
            $table->enum('state',['PENDIENTE','CREADO','RECHAZADO']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requirement_new_products');
    }
};
