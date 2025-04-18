<?php

namespace Src\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Src\Models\Carrinho;
use Src\Models\CompraFinalizada;

class CompraController
{
    public function finalizarCompra(Request $request, Response $response, array $args): Response
    {
        $userId = (int)$args['userId'];

        $itens = Carrinho::where('user_id', $userId)->get();

        if ($itens->isEmpty()) {
            $response->getBody()->write(json_encode(['error' => 'Carrinho vazio']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        $total = $itens->sum(fn($item) => $item->quantidade * $item->preco);

        $compra = CompraFinalizada::create([
            'user_id' => $userId,
            'total' => $total,
            'finalizado_em' => date('Y-m-d H:i:s'),
            'itens_json' => json_encode($itens),
        ]);

        Carrinho::where('user_id', $userId)->delete();

        $response->getBody()->write(json_encode([
            'success' => true,
            'total' => $total,
            'compra_id' => $compra->id,
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function listarCompras(Request $request, Response $response, array $args): Response
    {
        $compras = CompraFinalizada::where('user_id', (int)$args['userId'])
            ->orderBy('finalizado_em', 'desc')
            ->get()
            ->map(function ($compra) {
                $compra->itens = json_decode($compra->itens_json);
                unset($compra->itens_json);
                return $compra;
            });

        $response->getBody()->write(json_encode($compras));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
