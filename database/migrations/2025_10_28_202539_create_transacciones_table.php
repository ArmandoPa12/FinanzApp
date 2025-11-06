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
        Schema::create('transacciones', function (Blueprint $table) {
            $table->id();
            $table->boolean('tipo'); // 'ENTRADA' false, 'GASTO' true
            $table->decimal('monto', 10, 2);
            $table->boolean('tipo_pago'); //QR true, EFECTIVO false
            $table->text('descripcion')->nullable();

            $table->foreignId('categoria_id')
                  ->nullable()
                  ->constrained('categorias')
                  ->nullOnDelete(); // Si se borra la categoría, no borra la transacción

            $table->foreignId('persona_id')
                  ->nullable()
                  ->constrained('personas')
                  ->nullOnDelete();
            $table->date('fecha'); // fecha real de la transacción

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transacciones');
    }
};
