<?php

namespace Src\Controllers;
use Src\Models\Carrinho;
use Respect\Validation\Validator as v;

class CarrinhoController
{
    public function listar(Request $request, Response $response, array $args): Response
    {
        $itens = Carrinho::where('user_id', (int)$args['userId'])->get();

        $response->getBody()->write(json_encode($itens));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function removerItem(Request $request, Response $response, array $args): Response
    {
        $item = Carrinho::where('id', (int)$args['id'])
            ->where('user_id', (int)$args['userId'])
            ->first();

        if (!$item) {
            $response->getBody()->write(json_encode(['error' => 'Item não encontrado']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $item->delete();
        $response->getBody()->write(json_encode(['success' => true]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function limpar(Request $request, Response $response, array $args): Response
    {
        Carrinho::where('user_id', (int)$args['userId'])->delete();

        $response->getBody()->write(json_encode(['success' => true]));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
