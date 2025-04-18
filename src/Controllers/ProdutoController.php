<?php

namespace Src\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Src\Models\Produto;

class ProdutoController
{
    public function listar(Request $request, Response $response): Response
    {
        $produtos = Produto::all();

        $response->getBody()->write(json_encode($produtos));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function obter(Request $request, Response $response, array $args): Response
    {
        $id = (int) $args['id'];
        $produto = Produto::find($id);

        if (!$produto) {
            $response->getBody()->write(json_encode(['error' => 'Produto não encontrado']));

            return $response
                ->withStatus(404)
                ->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode($produto));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
