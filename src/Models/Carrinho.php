<?php
namespace Src\Models;

use Illuminate\Database\Eloquent\Model;

class Carrinho extends Model
{
    protected $table = 'carrinho';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'produto',
        'quantidade',
        'preco',
        'criado_em',
    ];

    public static function adicionar($userId, $produto, $quantidade, $preco)
    {
        return self::create([
            'user_id' => $userId,
            'produto' => $produto,
            'quantidade' => $quantidade,
            'preco' => $preco,
            'criado_em' => date('Y-m-d H:i:s'),
        ]);
    }

    public static function porUsuario($userId)
    {
        return self::where('user_id', $userId)->get();
    }

    public static function limparPorUsuario($userId)
    {
        return self::where('user_id', $userId)->delete();
    }

    public static function remover($id, $userId)
    {
        return self::where('id', $id)->where('user_id', $userId)->delete();
    }
}
