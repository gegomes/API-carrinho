<?php

namespace Src\Controllers;

use Src\Models\Carrinho;
use Respect\Validation\Validator as v;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Capsule\Manager as Capsule;

class CarrinhoController
{
    public function listar(Request $request, Response $response, array $args): Response {
        $userId = $args['userId'];
    
        $itens = Capsule::table('carrinho')
            ->join('produtos', 'carrinho.produto_id', '=', 'produtos.id')
            ->where('carrinho.user_id', $userId)
            ->select(
                'carrinho.id',
                'carrinho.user_id',
                'carrinho.produto_id',
                'carrinho.quantidade',
                'produtos.nome as produto',
                'produtos.preco',
                'produtos.image_url',
                Capsule::raw('(carrinho.quantidade * produtos.preco) as subtotal') // ✅ cálculo direto no SQL
            )
            ->get();
    
        $response->getBody()->write($itens->toJson());
        return $response->withHeader('Content-Type', 'application/json');
    }
    

    public function adicionarItem(Request $request, Response $response, array $args): Response {
        $body = $request->getParsedBody();
        $produto_id = (int)($body['produto_id'] ?? 0);
        $quantidade = (int)($body['quantidade'] ?? 1);
        $user_id = (int)$args['userId'];

        if (!$produto_id || !$quantidade) {
            $response->getBody()->write(json_encode(['error' => 'Dados inválidos']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        // Verifica se já existe esse produto no carrinho do usuário
        $existente = Carrinho::where('user_id', $user_id)
            ->where('produto_id', $produto_id)
            ->first();

        if ($existente) {
            // Atualiza a quantidade
            $existente->quantidade += $quantidade;
            $existente->save();
        } else {
            // Adiciona novo item
            $item = new Carrinho();
            $item->user_id = $user_id;
            $item->produto_id = $produto_id;
            $item->quantidade = $quantidade;
            $item->save();
        }

        $response->getBody()->write(json_encode(['success' => true]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function removerItem(Request $request, Response $response, array $args): Response {
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

    public function limpar(Request $request, Response $response, array $args): Response {
        Carrinho::where('user_id', (int)$args['userId'])->delete();

        $response->getBody()->write(json_encode(['success' => true]));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
