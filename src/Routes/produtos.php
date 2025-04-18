<?php
// src/Routes/produtos.php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface  as Request;
use Slim\App;

return function(App $app) {
    // GET /produtos
    $app->get('/produtos', function(Request $req, Response $res) {
        $db = new PDO('sqlite:' . __DIR__ . '/../../database/carrinho.sqlite');
        $items = $db->query('SELECT id, nome, descricao, preco, estoque FROM produtos')
                    ->fetchAll(PDO::FETCH_ASSOC);
        $res->getBody()->write(json_encode($items));
        return $res->withHeader('Content-Type', 'application/json');
    });

    // POST /produtos
    $app->post('/produtos', function(Request $req, Response $res) {
        $data = (array)$req->getParsedBody();
        $db = new PDO('sqlite:' . __DIR__ . '/../../database/carrinho.sqlite');
        $stmt = $db->prepare(
          'INSERT INTO produtos (nome, descricao, preco, estoque) VALUES (:nome,:descricao,:preco,:estoque)'
        );
        $stmt->execute([
          ':nome'      => $data['nome'] ?? '',
          ':descricao' => $data['descricao'] ?? '',
          ':preco'     => $data['preco'] ?? 0,
          ':estoque'   => $data['estoque'] ?? 0
        ]);
        $res->getBody()->write(json_encode(['id' => $db->lastInsertId()]));
        return $res->withHeader('Content-Type', 'application/json')->withStatus(201);
    });
};
