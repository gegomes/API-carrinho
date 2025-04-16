<?php
$db = new SQLite3(__DIR__ . '/../database/carrinho.sqlite');

// Remove a tabela antiga (opcional se estiver testando)
$db->exec('DROP TABLE IF EXISTS carrinho');

// criar carrinho de compras 
$db->exec('CREATE TABLE IF NOT EXISTS carrinho (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    produto TEXT NOT NULL,
    quantidade INTEGER NOT NULL,
    preco REAL NOT NULL,
    criado_em TEXT
)');


// Cria tabela de compras finalizadas
$db->exec('CREATE TABLE IF NOT EXISTS compras_finalizadas (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    total REAL NOT NULL,
    finalizado_em TEXT
)');


$db->exec('DROP TABLE IF EXISTS compras_finalizadas');

$db->exec('CREATE TABLE IF NOT EXISTS compras_finalizadas (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    total REAL NOT NULL,
    finalizado_em TEXT NOT NULL,
    itens_json TEXT
)');


echo "Banco atualizado com sucesso.\n";
