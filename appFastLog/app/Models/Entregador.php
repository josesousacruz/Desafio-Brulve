<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entregador extends Model
{
    use SoftDeletes, HasFactory;
    protected $table = 'entregador';
    protected $fillable = ['nome', 'telefone', 'tipoVeiculo'];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    public function setTelefoneAttribute($value)
    {
        $this->attributes['telefone'] = preg_replace('/[^0-9]/', '', $value);    
    }    
}
