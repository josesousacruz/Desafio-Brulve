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
        Schema::create('status_pedido', function (Blueprint $table) {
            $table->id();
            $table->string('status', 20);
            $table->timestamps();
        });

        DB::table('status_pedido')->insert([
            ['status' => 'criado'],
            ['status' => 'aguardando coleta'],
            ['status' => 'coleta realizada'], 
            ['status' => 'saiu para entrega'],
            ['status' => 'entrega realizada'],
            ['status' => 'cancelado']
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_pedido');
    }
};