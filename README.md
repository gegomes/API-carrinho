
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
  - [Listar Itens do Carrinho](#1-listar-itens-do-carrinho)
  - [Remover Item do Carrinho](#2-remover-item-do-carrinho)
  - [Limpar Carrinho](#3-limpar-carrinho)
  - [Finalizar Compra](#4-finalizar-compra)
  - [Histórico de Compras](#5-histórico-de-compras)
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

O script `scripts/create-db.php` cria três tabelas principais:

- **produtos**: catálogo de produtos com nome, descrição, imagem e preço.
- **carrinho**: armazena itens em aberto por `user_id`.
- **compras_finalizadas**: histórico de compras finalizadas.

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
│   ├── Controllers/
│   │   ├── CarrinhoController.php
│   │   ├── CompraController.php
│   │   └── ProdutoController.php
│   ├── Models/
│   │   ├── Carrinho.php
│   │   ├── CompraFinalizada.php
│   │   └── Produto.php
│   └── Routes/
│       └── api.php
├── composer.json          # Dependências e autoload
└── README.md              # Documentação do projeto
```

---

## Rotas da API

### 1. Listar Itens do Carrinho
```
GET /carrinho/{userId}
```
**Descrição:**
Retorna todos os itens no carrinho do usuário.

---

### 2. Remover Item do Carrinho
```
DELETE /carrinho/{userId}/item/{id}
```
**Descrição:**
Remove o item especificado pelo `id`.

---

### 3. Limpar Carrinho
```
DELETE /carrinho/{userId}/limpar
```
**Descrição:**
Remove todos os itens do carrinho do usuário.

---

### 4. Finalizar Compra
```
POST /carrinho/{userId}/finalizar
```
**Descrição:**
- Calcula o total de todos os itens.
- Insere um registro em `compras_finalizadas` com `total` e `finalizado_em`.
- Limpa o carrinho ativo.

**Resposta Exemplo:**
```json
{
  "success": true,
  "total": 2000
}
```

---

### 5. Histórico de Compras
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
