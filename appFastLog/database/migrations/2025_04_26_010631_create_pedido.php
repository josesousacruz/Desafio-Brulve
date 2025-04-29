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
        Schema::create('pedido', function (Blueprint $table) {
            $table->id();
            $table->string('numeroPedido', 50)->unique();
            $table->string('destinatarioNome', 100);
            $table->string('destinatarioEndereco', 255);
            $table->string('destinatarioTelefone', 20);
            $table->string('itemDescricao', 255);
            $table->unsignedBigInteger('status_pedido_id')->default(1); // Default para 'criado'
            $table->foreign('status_pedido_id')->references('id')->on('status_pedido');
            $table->unsignedBigInteger('entregador_id');
            $table->foreign('entregador_id')->references('id')->on('entregador');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido');
    }
};
