# API de Carrinho de Compras (Slim + SQLite)

Este projeto implementa uma API RESTful em PHP utilizando o Slim Framework e SQLite para gerenciamento de um carrinho de compras com suporte a múltiplos usuários.

---

## 📋 Sumário

- [Tecnologias](#tecnologias)
- [Pré-requisitos](#pré-requisitos)
- [Instalação](#instalação)
- [Configuração do Banco de Dados](#configuração-do-banco-de-dados)
- [Estrutura de Pastas](#estrutura-de-pastas)
- [Rotas da API](#rotas-da-api)
  - [Adicionar Item ao Carrinho](#1-adicionar-item-ao-carrinho)
  - [Listar Itens do Carrinho](#2-listar-itens-do-carrinho)
  - [Remover Item do Carrinho](#3-remover-item-do-carrinho)
  - [Limpar Carrinho](#4-limpar-carrinho)
  - [Finalizar Compra](#5-finalizar-compra)
  - [Histórico de Compras](#6-histórico-de-compras)
- [Teste com cURL](#teste-com-curl)
- [Fluxo de Usuários Simultâneos](#fluxo-de-usuários-simultâneos)
- [Publicação no GitHub](#publicação-no-github)
- [Contribuição](#contribuição)
- [Licença](#licença)

---

## Tecnologias

- PHP 8.x
- [Slim Framework 4](https://www.slimframework.com/)
- SQLite 3
- Composer para gerenciamento de dependências

---

## Pré-requisitos

- PHP 8.0 ou superior
- Composer 2.x
- Extensão PDO_SQLITE habilitada

---

## Instalação

1. Clone o repositório:
   ```bash
   git clone https://github.com/seu-usuario/api-carrinho.git
   cd api-carrinho
   ```

2. Instale as dependências:
   ```bash
   composer install
   ```

3. Crie o banco de dados SQLite:
   ```bash
   php scripts/create-db.php
   ```

4. Inicie o servidor de desenvolvimento:
   ```bash
   php -S localhost:8000 -t public
   ```

O servidor ficará disponível em `http://localhost:8000`.

---

## Configuração do Banco de Dados

O script `scripts/create-db.php` cria duas tabelas principais:

- **carrinho**: armazena itens em aberto por `user_id`.
- **compras**: histórico de compras finalizadas.

Caso queira adicionar uma tabela de `produtos`, pode utilizar o seguinte SQL:

```sql
CREATE TABLE produtos (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  nome TEXT NOT NULL,
  descricao TEXT,
  preco REAL NOT NULL,
  estoque INTEGER NOT NULL DEFAULT 0,
  criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

---

## Estrutura de Pastas

```
api-carrinho/
├── database/              # Arquivo SQLite (carrinho.sqlite)
├── public/                # Ponto de entrada público
│   └── index.php          # Bootstrap do Slim
├── scripts/               # Scripts auxiliares
│   └── create-db.php      # Cria o banco de dados
├── src/                   # Código-fonte
│   ├── Models/
│   │   ├── Carrinho.php
│   │   └── CompraFinalizada.php
│   └── Routes/
│       ├── carrinho.php
│       └── produtos.php   # (Opcional) CRUD de produtos
├── composer.json          # Dependências e autoload
└── README.md              # Documentação do projeto
```

---

## Rotas da API

### 1. Adicionar Item ao Carrinho
```
POST /carrinho/adicionar
```
**Body (JSON):**
```json
{
  "user_id": 1,
  "produto_id": 42,
  "quantidade": 2
}
```
**Descrição:**
- Recupera preço e estoque do produto a partir de `produto_id`.
- Valida disponibilidade.
- Insere item na tabela `carrinho` e decremeta o estoque (opcional).

---

### 2. Listar Itens do Carrinho
```
GET /carrinho/{userId}
```
**Descrição:**
Retorna todos os itens no carrinho do usuário.

---

### 3. Remover Item do Carrinho
```
DELETE /carrinho/{userId}/item/{id}
```
**Descrição:**
Remove o item especificado pelo `id` e restaura o estoque (se implementado).

---

### 4. Limpar Carrinho
```
DELETE /carrinho/{userId}/limpar
```
**Descrição:**
Remove todos os itens do carrinho do usuário.

---

### 5. Finalizar Compra
```
POST /carrinho/{userId}/finalizar
```
**Descrição:**
- Calcula o total de todos os itens.
- Insere um registro em `compras` com `total` e `finalizado_em`.
- Limpa o carrinho ativo.

**Resposta Exemplo:**
```json
{
  "success": true,
  "total": 2000
}
```

---

### 6. Histórico de Compras
```
GET /compras/{userId}
```
**Descrição:**
Retorna o histórico de compras finalizadas, incluindo detalhes dos itens em `itens_json`.

**Resposta Exemplo:**
```json
[
  {
    "id": 1,
    "user_id": 1,
    "total": 2000,
    "finalizado_em": "2025-04-16 00:00:00",
    "itens": [
      { "produto": "notebook", "quantidade": 2, "preco": 1000 }
    ]
  }
]
```

---

## Teste com cURL

```bash
# Adicionar item
curl -X POST http://localhost:8000/carrinho/adicionar      -H "Content-Type: application/json"      -d '{"user_id": 1, "produto_id": 42, "quantidade": 1}'

# Listar itens
curl http://localhost:8000/carrinho/1

# Remover item
curl -X DELETE http://localhost:8000/carrinho/1/item/1

# Limpar carrinho
curl -X DELETE http://localhost:8000/carrinho/1/limpar

# Finalizar compra
curl -X POST http://localhost:8000/carrinho/1/finalizar

# Ver histórico de compras
curl http://localhost:8000/compras/1
```

---

## Fluxo de Usuários Simultâneos

Para simular diversos usuários, basta passar `user_id` diferente em cada requisição. Cada carrinho é isolado por `user_id`, garantindo operações independentes.

---

## Publicação no GitHub

Repositório público: https://github.com/seu-usuario/api-carrinho


## Contribuição

Sinta-se à vontade para abrir issues e pull requests. Para clonar e rodar localmente, siga as instruções acima.

---

## Licença

MIT © Geinian Teixeira
