# API-carrinho
Criação de uma carrinho de compras utilizando o PHP
# API Carrinho de Compras 🛒

API RESTful desenvolvida em PHP com o microframework **Slim** e banco de dados **SQLite**, para simular operações básicas de um carrinho de compras.

---

## 🔧 Requisitos

- PHP 8.0+
- Composer
- SQLite3

---

## 📦 Instalação

1. Clone o repositório:

```bash
git clone https://github.com/SEU_USUARIO/API-carrinho.git
cd API-carrinho
```

2. Instale as dependências:

```bash
composer install
```

3. Crie o banco de dados:

```bash
php scripts/create-db.php
```

4. Inicie o servidor embutido do PHP:

```bash
php -S localhost:8000 -t public
```

A API estará disponível em `http://localhost:8000`.

---

## 🔁 Rotas da API

### ➕ Adicionar item ao carrinho

```http
POST /carrinho/adicionar
```

**Body JSON:**

```json
{
  "produto": "Monitor 24",
  "quantidade": 2,
  "preco": 899.90
}
```

---

### 📦 Listar itens do carrinho

```http
GET /carrinho
```

---

### ❌ Remover item do carrinho

```http
DELETE /carrinho/{id}
```

---

### 💳 Finalizar compra

```http
POST /carrinho/finalizar
```

**Retorna:**

```json
{
  "total": 1799.80
}
```

---

## 📁 Estrutura de Pastas

```
.
├── database/
│   └── carrinho.sqlite
├── public/
│   └── index.php
├── scripts/
│   └── create-db.php
├── src/
│   ├── Controllers/
│   ├── Models/
│   │   └── Carrinho.php
│   └── Routes/
│       └── carrinho.php
```

---

## ✅ Contribuições

Pull requests são bem-vindos para melhorias, testes automatizados ou novas funcionalidades.

---

## 🧠 Observações

- A API está pronta para ser consumida por um frontend como React ou Next.js.
- Todos os dados são armazenados localmente em SQLite para facilitar testes locais.
- O CRUD visual foi removido para manter apenas a API pura conforme o desafio proposto.

---

## 🧑‍💻 Autor

**Geinian Teixeira**