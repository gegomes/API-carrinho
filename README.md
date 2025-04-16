# 🛒 API de Carrinho de Compras (Slim + SQLite)

API RESTful em PHP utilizando Slim Framework e SQLite para gestão de carrinho de compras com suporte a múltiplos usuários simultâneos.

---

## 🚀 Instruções para Executar

```bash
# Clonar o projeto
git clone https://github.com/seu-usuario/api-carrinho.git
cd api-carrinho

# Instalar dependências
composer install

# Criar o banco de dados
php scripts/create-db.php

# Iniciar o servidor
php -S localhost:8000 -t public
```

---

## 📦 Rotas da API

### 1. Adicionar item ao carrinho
```
POST /carrinho/adicionar
```
**Body (JSON):**
```json
{
  "user_id": 1,
  "produto": "notebook",
  "quantidade": 2,
  "preco": 1000
}
```
**Descrição:** Adiciona um novo item ao carrinho do usuário informado.

---

### 2. Listar itens do carrinho do usuário
```
GET /carrinho/{userId}
```
**Descrição:** Retorna todos os itens no carrinho do usuário.

---

### 3. Remover item do carrinho do usuário
```
DELETE /carrinho/{userId}/item/{id}
```
**Descrição:** Remove um item específico do carrinho do usuário.

---

### 4. Limpar carrinho do usuário
```
DELETE /carrinho/{userId}/limpar
```
**Descrição:** Remove todos os itens do carrinho do usuário.

---

### 5. Finalizar compra do usuário
```
POST /carrinho/{userId}/finalizar
```
**Descrição:** Finaliza a compra e armazena o histórico.

**Resposta:**
```json
{
  "success": true,
  "total": 2000
}
```

---

### 6. Listar compras finalizadas do usuário
```
GET /compras/{userId}
```
**Descrição:** Retorna o histórico de compras finalizadas de um usuário.

**Resposta:**
```json
[
  {
    "id": 1,
    "user_id": 1,
    "total": 2000,
    "finalizado_em": "2025-04-16 00:00:00",
    "itens": [
      {
        "produto": "notebook",
        "quantidade": 2,
        "preco": 1000
      }
    ]
  }
]
```

---

## 🧪 Testes com curl (Exemplos)

```bash
# Adicionar item
curl -X POST http://localhost:8000/carrinho/adicionar \
     -H "Content-Type: application/json" \
     -d '{"user_id": 1, "produto": "Mouse", "quantidade": 1, "preco": 50}'

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

## 🧠 Observações
- Cada rota está preparada para simular usuários distintos.
- O campo `user_id` é usado para isolar as operações por usuário.
- O histórico de compras inclui todos os itens finalizados por usuário.
- Os itens são armazenados no campo `itens_json` e retornados no campo `itens` já decodificados.

---

## 📁 Estrutura de Pastas
```
api-carrinho/
├── database/
│   └── carrinho.sqlite
├── public/
│   └── index.php
├── scripts/
│   └── create-db.php
├── src/
│   ├── Models/
│   │   ├── Carrinho.php
│   │   └── CompraFinalizada.php
│   └── Routes/
│       └── carrinho.php
├── composer.json
└── README.md
```

---

## 👤 Autor
**Geinian Teixeira**
