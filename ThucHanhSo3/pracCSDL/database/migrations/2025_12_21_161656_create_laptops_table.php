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
        Schema::create('laptops', function (Blueprint $table) {
            $table->id(); // Mã laptop (Primary Key)
            $table->string('brand');
            $table->string('model');
            $table->string('specifications');
            $table->boolean('rental_status')->default(false);
            // Khai báo khóa ngoại liên kết với bảng renters
            $table->foreignId('renter_id')->nullable()->constrained('renters')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laptops');
    }
};
