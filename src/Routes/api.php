<?php

use Slim\App;
use Src\Controllers\CarrinhoController;
use Src\Controllers\CompraController;
use Src\Controllers\ProdutoController;

return function (App $app) {

    // Rotas do Carrinho

    $app->get('/carrinho/{userId}', [CarrinhoController::class, 'listar']);
    $app->delete('/carrinho/{userId}/item/{id}', [CarrinhoController::class, 'removerItem']);
    $app->delete('/carrinho/{userId}/limpar', [CarrinhoController::class, 'limpar']);
    $app->post('/carrinho/{userId}/item', [CarrinhoController::class, 'adicionarItem']);

    // Rotas para Compras
    $app->post('/carrinho/{userId}/finalizar', [CompraController::class, 'finalizarCompra']);
    $app->get('/compras/{userId}', [CompraController::class, 'listarCompras']);

    // Rotas para Produtos
    $app->get('/produtos', [ProdutoController::class, 'listar']);
    $app->get('/produtos/{id}', [ProdutoController::class, 'obter']);
};
