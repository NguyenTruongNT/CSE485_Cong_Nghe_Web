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
        Schema::create('sales', function (Blueprint $table) {
            $table->id('sale_id');
            // Cách viết mới: tạo cột và liên kết khóa ngoại trong 1 dòng
            $table->foreignId('medicine_id')->constrained('medicines', 'medicine_id')->onDelete('cascade');
            $table->integer('quantity');
            $table->dateTime('sale_date');
            $table->string('customer_phone', 10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
