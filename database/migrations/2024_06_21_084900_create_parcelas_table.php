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
        Schema::create('parcelas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('numero_parcela');
            $table->foreignId('venda_id')->constrained('vendas');
            $table->decimal('valor_parcela', 10, 2);
            $table->string('vencimento');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parcelas');
    }
};
