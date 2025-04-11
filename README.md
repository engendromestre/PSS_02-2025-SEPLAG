# 📄 Projeto: API de Pessoas com Autorização e Documentação Swagger

<p align="center">
<a href="LICENSE">
  <img src="https://img.shields.io/badge/license-MIT-green">
</a>
<img src="https://img.shields.io/badge/release date-Apr/2025-yellow">
</p>
<p align="center">
<img src="https://img.shields.io/badge/PHP 8.2.28-777BB4?style=for-the-badge&logo=php&logoColor=white">
<img src="https://img.shields.io/badge/Laravel 12.6.0-FF2D20?style=for-the-badge&logo=laravel&logoColor=white">
<img src="https://img.shields.io/badge/PostgreSQL-latest-336791?style=for-the-badge&logo=postgresql&logoColor=white">
<img src="https://img.shields.io/badge/Nginx-latest-009639?style=for-the-badge&logo=nginx&logoColor=white">
<img src="https://img.shields.io/badge/MinIO-latest-C72E1C?style=for-the-badge&logo=minio&logoColor=white">
</p>
<p align="center">
<a href="https://linktr.ee/prbo" target="_blank"><img src="https://img.shields.io/badge/linktree-39E09B?style=for-the-badge&logo=linktree&logoColor=white"></a>
</p>

## 👤 Informações do Candidato

-   **Nome**: Paulo Roberto Barbosa de Oliveira
-   **Email**: prbo0417@gmail.com
-   **GitHub**: [https://github.com/engendromestre](https://github.com/engendromestre)
-   **Telefone**: (14) 99795-3112

---

## 📦 Requisitos

-   Docker
-   Docker Compose
-   Git

## 🚀 Como executar o projeto

### 1. Clone o repositório e inicie o docker compose

```bash
git clone https://github.com/engendromestre/PSS_02-2025-SEPLAG.git api-php
cd api-php
docker compose up
```

### 2. Instale as dependências

```bash
docker compose exec app composer install
```

### 3. Copie e configure o .env

```bash
cp .env.example .env
```

### 4. Configure as variáveis de ambiente

```bash
APP_URL=http://localhost:8000
L5_SWAGGER_CONST_HOST=http://localhost:8000
L5_SWAGGER_GENERATE_ALWAYS=true
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=mydatabase
DB_USERNAME=admin
DB_PASSWORD=admin
FILESYSTEM_DISK=minio
MINIO_ENDPOINT=http://minio:9000
MINIO_ACCESS_KEY=minioadmin
MINIO_SECRET_KEY=minioadmin
MINIO_BUCKET=fotos

### 5. Gere a chave da aplicação

```bash
docker compose exec app php artisan key:generate
```

## 🧪 Como testar a API

### Usando Swagger (L5-Swagger)

Gere os usuários com seus respectivos papéis
```bash
docker compose exec app php artisan migrate --seed
```

### 🧾 Controle de Acesso por Papéis (Roles)

A aplicação usa um campo role na tabela users para definir permissões de acesso. Para efeitos de teste, foram criados um usuário para cada role:

-   admin - admin@example.com | senha
-   editor - editor@example.com | password
-   user - user@example.com | password

### 🔐 Autenticação

A API utiliza Laravel Sanctum para autenticação

```bash
POST /api/login
```

Copie o token de acesso

```json
{
    "token": "seu_token"
}
```

Use o token para autenticação nas requisições (Botão Authorize - ícone do cadeado):

```bash
Authorization: Bearer seu_token_aqui
```

### ✅ Exemplos de rotas

Listar pessoas (admin/editor)

```bash
GET /api/pessoas
Authorization: Bearer seu_token
```

```bash
POST /api/pessoas
Authorization: Bearer seu_token
```

### 🧬 Estrutura do Modelo Pessoa

```json
{
    "pes_id": 1,
    "pes_nome": "Ana Maria",
    "pes_data_nascimento": "1986-02-08",
    "idade": 39,
    "pes_sexo": "M",
    "pes_mae": "Mãe da Ana Maria",
    "pes_pai": "Pai da Ana Maria",
    "fotos": [],
    "servidores_efetivos": [],
    "servidores_temporarios": []
}
```
