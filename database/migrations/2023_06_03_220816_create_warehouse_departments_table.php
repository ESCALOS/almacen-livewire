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
        Schema::create('warehouse_departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warehouse_detail_id')->constrained();
            $table->foreignId('department_id')->constrained();
            $table->decimal('quantity',8,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_departments');
    }
};
