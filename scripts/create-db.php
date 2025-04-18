<?php
$db = new SQLite3(__DIR__ . '/../database/carrinho.sqlite');

// Remove a tabela antiga (opcional se estiver testando)
$db->exec('DROP TABLE IF EXISTS carrinho');


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


// criar tabela de produtos (catálogo)
$db->exec('CREATE TABLE IF NOT EXISTS produtos (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    nome        TEXT    NOT NULL,
    descricao   TEXT    NULL,
    preco       REAL    NOT NULL,
    image_url   TEXT    NULL
)');

// 2) POPULAÇÃO COM DADOS DE EXEMPLO
$produtos = [
    ['Camisa de gola P', '100% algodão P',      55.00,   null],
    ['Calça Jeans',       'Jeans azul escura', 120.00, 'https://via.placeholder.com/150'],
    ['Tênis Esportivo',   'Corrida unissex',    230.00,   null],
];
$stmt = $db->prepare('INSERT INTO produtos (nome, descricao, preco, image_url) VALUES (:n,:d,:p,:i)');
foreach ($produtos as $p) {
    [$n, $d, $pr, $img] = $p;
    $stmt->bindValue(':n',   $n,   SQLITE3_TEXT);
    $stmt->bindValue(':d',   $d,   SQLITE3_TEXT);
    $stmt->bindValue(':p',   $pr,  SQLITE3_FLOAT);
    $stmt->bindValue(':i',   $img, SQLITE3_TEXT);
    $stmt->execute();
}

echo "Banco atualizado com sucesso.\n";
