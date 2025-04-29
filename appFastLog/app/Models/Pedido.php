<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use SoftDeletes;
    protected $table = 'pedido';
    protected $fillable = ['numeroPedido', 'destinatarioNome', 'destinatarioEndereco', 'destinatarioTelefone', 'itemDescricao','entregador_id','status'];
    
    public function entregador()
    {
        return $this->belongsTo(Entregador::class);
    }
}
