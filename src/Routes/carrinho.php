<?php

use Slim\App;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Src\Models\Carrinho;
use Src\Models\CompraFinalizada; 


return function (App $app) {

    // ✅ Adicionar item ao carrinho de um usuário
    $app->post('/carrinho/adicionar', function (Request $request, Response $response) {
        $data = $request->getParsedBody();

        $item = Carrinho::create([
            'user_id'    => $data['user_id'], // NOVO
            'produto'    => $data['produto'],
            'quantidade' => $data['quantidade'],
            'preco'      => $data['preco'],
            'criado_em'  => date('Y-m-d H:i:s'),
        ]);

        $response->getBody()->write(json_encode($item));
        return $response->withHeader('Content-Type', 'application/json');
    });

    // ✅ Listar itens do carrinho de um usuário
    $app->get('/carrinho/{userId}', function (Request $request, Response $response, array $args) {
        $userId = (int) $args['userId'];
        $itens = Carrinho::where('user_id', $userId)->get();

        $response->getBody()->write(json_encode($itens));
        return $response->withHeader('Content-Type', 'application/json');
    });

    // ✅ Remover item do carrinho de um usuário
    $app->delete('/carrinho/{userId}/item/{id}', function (Request $request, Response $response, array $args) {
        $userId = (int) $args['userId'];
        $id = (int) $args['id'];

        $item = Carrinho::where('id', $id)->where('user_id', $userId)->first();

        if (!$item) {
            $response->getBody()->write(json_encode(['error' => 'Item não encontrado']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $item->delete();
        $response->getBody()->write(json_encode(['success' => true]));
        return $response->withHeader('Content-Type', 'application/json');
    });

    // ✅ Limpar carrinho de um usuário
    $app->delete('/carrinho/{userId}/limpar', function (Request $request, Response $response, array $args) {
        $userId = (int) $args['userId'];
        Carrinho::where('user_id', $userId)->delete();

        $response->getBody()->write(json_encode(['success' => true]));
        return $response->withHeader('Content-Type', 'application/json');
    });

    // ✅ Finalizar compra (somente do usuário)
   
    $app->post('/carrinho/{userId}/finalizar', function (Request $request, Response $response, array $args) {
        $userId = (int) $args['userId'];
    
        // Pega todos os itens do usuário
        $itens = Carrinho::where('user_id', $userId)->get();
    
        // Calcula o total
        $total = $itens->reduce(function ($carry, $item) {
            return $carry + ($item->quantidade * $item->preco);
        }, 0);
    
        // Salva a compra finalizada com os itens
        CompraFinalizada::create([
            'user_id' => $userId,
            'total' => $total,
            'finalizado_em' => date('Y-m-d H:i:s'),
            'itens_json' => json_encode($itens),
        ]);
    
        // Limpa o carrinho do usuário
        Carrinho::where('user_id', $userId)->delete();
    
        $response->getBody()->write(json_encode([
            'success' => true,
            'total' => $total,
        ]));
    
        return $response->withHeader('Content-Type', 'application/json');
    });


     //  listar compras finalizadas

     $app->get('/compras/{userId}', function (Request $request, Response $response, array $args) {
        $userId = (int) $args['userId'];
    
        $compras = CompraFinalizada::where('user_id', $userId)
            ->orderBy('finalizado_em', 'desc')
            ->get()
            ->map(function ($compra) {
                $compra->itens = json_decode($compra->itens_json); // ✅ decodifica os itens
                unset($compra->itens_json);
                return $compra;
            });
    
        $response->getBody()->write(json_encode($compras));
        return $response->withHeader('Content-Type', 'application/json');
    });
};