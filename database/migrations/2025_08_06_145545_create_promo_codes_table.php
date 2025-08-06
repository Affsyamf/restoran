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
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('type', ['fixed', 'percent']); // Tipe diskon: potongan harga tetap atau persentase
            $table->decimal('value', 15, 2); // Nilai diskon
            $table->unsignedInteger('max_uses')->nullable(); // Batas maksimal penggunaan (opsional)
            $table->unsignedInteger('uses')->default(0); // Berapa kali sudah digunakan
            $table->timestamp('expires_at')->nullable(); // Tanggal kadaluarsa (opsional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_codes');
    }
};
