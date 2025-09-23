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
        Schema::create('trans_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_customer')->constrained('customers');
            $table->string('order_code', 50);
            $table->date('order_date');
            $table->date('order_end_date');
            $table->tinyInteger('order_status');
            $table->integer('order_pay');
            $table->integer('order_change');
            $table->integer('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trans_orders');
    }
};
