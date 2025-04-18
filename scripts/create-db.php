<?php
$db = new SQLite3(__DIR__ . '/../database/carrinho.sqlite');

// Remove a tabela carrinho (caso esteja testando)
$db->exec('DROP TABLE IF EXISTS carrinho');

// Remove a tabela de compras finalizadas (caso esteja testando)
$db->exec('DROP TABLE IF EXISTS compras_finalizadas');

// Remove a tabela de produtos (evita duplicações no catálogo)
$db->exec('DROP TABLE IF EXISTS produtos');

// Cria tabela de compras finalizadas
$db->exec('CREATE TABLE IF NOT EXISTS compras_finalizadas (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    total REAL NOT NULL,
    finalizado_em TEXT NOT NULL,
    itens_json TEXT
)');

// Cria a tabela carrinho (temporária até finalizar a compra)
$db->exec('CREATE TABLE IF NOT EXISTS carrinho (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    produto_id INTEGER NOT NULL,
    quantidade INTEGER NOT NULL
)');

// Cria tabela de produtos (catálogo)
$db->exec('CREATE TABLE IF NOT EXISTS produtos (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    nome        TEXT    NOT NULL,
    descricao   TEXT    NULL,
    preco       REAL    NOT NULL,
    image_url   TEXT    NULL
)');

// Popula com dados de exemplo
$produtos = [
    ['Geladeira Frost Free', '375L, Inox, degelo automático', 2899.00, "https://encrypted-tbn1.gstatic.com/shopping?q=tbn:ANd9GcSi5hCXHhUJmQKPtAAczK6VzhRf24GlChxZVYunNJCC_M4IhFYgje4Zdpy-3OypDL64OZu2MgFrbx2Qn9g0Wf168fX90RxzuljyGclrHbplYox560Gt8F9XsHPr8VX-wy9wJYzwW-l37MU&usqp=CAc"],
    ['Fogão 4 bocas', 'Acendimento automático, Inox', 799.00, 'https://encrypted-tbn1.gstatic.com/shopping?q=tbn:ANd9GcSluEnH07-8agDPmcFxN-K696MkXeReinhQeESY1PLbVs1Klga4b9_vwUXzaGgI5TaH0NNv6vPoKSbpLreES504ilu3AsfSkN6hsVc8Hjp2Obawh15wZ5RKQQjr5jGe&usqp=CAc'],
    ['Máquina de Lavar 11kg', 'Econômica, abertura superior', 1799.00, 'https://encrypted-tbn1.gstatic.com/shopping?q=tbn:ANd9GcTtLIeNp2VDHraMjPh3hEDEYIupbI8sUJKThoNjkR6vod6lb_psbH1dK7sKztmDO5ZXaCbsbdwf1bcD5iOenCbqcblp6LceEhld-gqK5PVbclBLxSzut_zV-G11e4mXwfWv5s-V6QE&usqp=CAc'],
    ['Micro-ondas 30L', 'Função descongelar, display digital', 599.00, 'https://encrypted-tbn0.gstatic.com/shopping?q=tbn:ANd9GcTRUpgkxbe-aQ7-KEKCRmcVyqPPy8ACnB3pXUpKmQnLWGlwSiWIIZKxqNer8PXFik3xK0TwsTGazYJkQmogMa0NPT8V2SqQ1xpYMTDpNJCEXBUVsKGWaQak3ZzBXWHmYePXNt0MZw&usqp=CAc'],
    ['Aspirador de Pó Vertical', 'Filtro HEPA, potente e leve', 349.00, 'https://encrypted-tbn3.gstatic.com/shopping?q=tbn:ANd9GcS0-oWZphEj8QSV93Avg6_9zjo5D3YvVWwwFGJHRjO0061Jyka5A2pjyZe2IrP4WZGVk2ozgEupseTUcj5N0UTWM6VO8GFoghGwCoW3wTEj8mioJJBYmIYRhEPKakHBZp_MTmyuCQ&usqp=CAc'],
    ['Liquidificador 900W', 'Com 12 velocidades e copo grande', 189.00, 'https://encrypted-tbn2.gstatic.com/shopping?q=tbn:ANd9GcTBXYw2k46yKvvPS80ZZw-6If6jISj1GHRusEu8E9b41oy0cKtCZ5E9JYg5OL5Wml-VF4mclAz7gkuxqGcawy5ianAchI5cO0axb45MostM2eoaAiKlfO1BeSZ1GXhjjO9bx9khXg&usqp=CAc'],
    ['Liquidificador Mondial ', 'Com 12 velocidades e copo grande', 189.00, 'https://a-static.mlcdn.com.br/800x560/liquidificador-mondial-turbo-power-l-99-fb-3-veloc-550w-preto/techshop/liqmon00019/2c6d79bbe9480e21a22f3efae7837bed.jpeg'],

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
