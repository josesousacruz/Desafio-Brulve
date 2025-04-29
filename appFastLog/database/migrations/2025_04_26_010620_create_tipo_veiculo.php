<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Adicionar esta linha

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tipo_veiculo', function (Blueprint $table) {
            $table->id();
            $table->string('tipo', 15);
            $table->timestamps();
        });

        DB::table('tipo_veiculo')->insert([
            ['tipo' => 'bicicleta'],
            ['tipo' => 'caminhão'],
            ['tipo' => 'van'],
            ['tipo' => 'motocicleta']
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_veiculo');
    }
};
