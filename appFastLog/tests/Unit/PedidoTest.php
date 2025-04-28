<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Pedido;
use App\Models\Entregador;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\QueryException;
use Illuminate\Database\UniqueConstraintViolationException;

class PedidoTest extends TestCase
{
    use RefreshDatabase;

    public function test_criar_pedido_valido(): void
    {
        $entregador = Entregador::factory()->create();

        $info_pedido = [
            'numeroPedido' => 'PED123456',
            'destinatarioNome' => 'João Silva',
            'destinatarioEndereco' => 'Rua das Flores, 123',
            'destinatarioTelefone' => '71999999999',
            'itemDescricao' => 'Produto XYZ',
            'entregador_id' => $entregador->id,
        ];

        $pedido = Pedido::create($info_pedido);

        $this->assertDatabaseHas('pedido', [
            'numeroPedido' => 'PED123456',
            'destinatarioNome' => 'João Silva'
        ]);
    }

    public function test_criar_pedido_duplicado_exception(){
        $entregador = Entregador::factory()->create();

        $dadosPedido = [
            'numeroPedido' => 'PED123456',
            'destinatarioNome' => 'João Silva',
            'destinatarioEndereco' => 'Rua das Flores, 123',
            'destinatarioTelefone' => '71999999999',
            'itemDescricao' => 'Produto XYZ',
            'entregador_id' => $entregador->id,
        ];

        Pedido::create($dadosPedido);

        $this->expectException(UniqueConstraintViolationException::class);
        Pedido::create($dadosPedido);

    }

}
