<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoVeiculo extends Model
{
    use HasFactory;

    protected $table = 'tipo_veiculo';

    protected $fillable = [
        'tipo',
    ];

    public function entregadores()
    {
        return $this->hasMany(Entregador::class);
    }
}