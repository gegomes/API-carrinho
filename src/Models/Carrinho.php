<?php
namespace Src\Models;

use Illuminate\Database\Eloquent\Model;

class Carrinho extends Model
{
    protected $table = 'carrinho';
    public $timestamps = false;

    protected $fillable = [
        'produto',
        'quantidade',
        'preco',
        'criado_em',
    ];
}
