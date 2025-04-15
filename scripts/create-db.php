<?php
$db = new SQLite3(__DIR__ . '/../database/carrinho.sqlite');

$db->exec('CREATE TABLE IF NOT EXISTS carrinho (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    produto TEXT NOT NULL,
    quantidade INTEGER NOT NULL,
    preco REAL NOT NULL,
    criado_em TEXT
)');

echo "Banco criado com sucesso.\n";
