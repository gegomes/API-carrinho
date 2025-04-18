<?php
namespace Src\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    // nome da tabela no SQLite
    protected $table = 'produtos';

    // campos que podem ser preenchidos em mass-assignment
    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'image_url'
    ];

    // não usamos created_at / updated_at
    public $timestamps = false;
}
