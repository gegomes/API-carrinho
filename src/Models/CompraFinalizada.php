<?php
namespace Src\Models;

use Illuminate\Database\Eloquent\Model;

class CompraFinalizada extends Model
{
    protected $table = 'compras_finalizadas';
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'total',
        'finalizado_em',
        'itens_json', 
    ];
}
