<?php

use Slim\App;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Src\Models\Carrinho;

return function (App $app) {

    // Listar itens do carrinho
    $app->get('/carrinho', function (Request $request, Response $response) {
        $itens = Carrinho::all();
        $response->getBody()->write(json_encode($itens));
        return $response->withHeader('Content-Type', 'application/json');
    });

    // Adicionar item ao carrinho
    $app->post('/carrinho/adicionar', function (Request $request, Response $response) {
        $data = $request->getParsedBody();

        $item = Carrinho::create([
            'produto'    => $data['produto'],
            'quantidade' => $data['quantidade'],
            'preco'      => $data['preco'],
            'criado_em'  => date('Y-m-d H:i:s'),
        ]);

        $response->getBody()->write(json_encode($item));
        return $response->withHeader('Content-Type', 'application/json');
    });

    // Remover item do carrinho
    $app->delete('/carrinho/{id}', function (Request $request, Response $response, array $args) {
        $item = Carrinho::find($args['id']);

        if (!$item) {
            $response->getBody()->write(json_encode(['error' => 'Item não encontrado']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $item->delete();
        $response->getBody()->write(json_encode(['success' => true]));
        return $response->withHeader('Content-Type', 'application/json');
    });

    // Finalizar compra (limpar o carrinho)
    $app->post('/carrinho/finalizar', function (Request $request, Response $response) {
        Carrinho::truncate();
        $response->getBody()->write(json_encode(['success' => true]));
        return $response->withHeader('Content-Type', 'application/json');
    });
};
