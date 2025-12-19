# 🚀 Damas Tech API

> Plataforma de educação, comunidade e empregabilidade para mulheres na tecnologia.

[![Laravel](https://img.shields.io/badge/Laravel-12.x-4A0676?logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-%5E8.2-35055C?logo=php&logoColor=white)](https://php.net)
[![Docs](https://img.shields.io/badge/Docs-OpenAPI_3-51139C)](damas-tech-app/docs/openapi.yaml)
[![Style](https://img.shields.io/badge/Quality-PHP_Insights_~90%25-E113FC)](#qualidade-e-boas-práticas)
[![License](https://img.shields.io/badge/License-MIT-1E1E1E)](LICENSE)

---

## 📋 Índice

- [Sobre o Projeto](#sobre-o-projeto)
- [Funcionalidades](#funcionalidades)
- [Tecnologias](#tecnologias)
- [Ambiente Local](#ambiente-local)
- [Instalação Rápida](#instalação-rápida)
- [Configuração](#configuração)
- [Fluxos Principais da API](#fluxos-principais-da-api)
- [Estrutura do Projeto](#estrutura-do-projeto)
- [Qualidade e Boas Práticas](#qualidade-e-boas-práticas)
- [Contribuição](#contribuição)
- [Licença](#licença)

---

## 🎯 Sobre o Projeto

A **Damas Tech API** é o backend da plataforma que une **educação em tecnologia** e **empregabilidade feminina**.

Ela oferece trilhas de estudo, acompanhamento de progresso, geração de certificados e um motor de **match** entre
talentos e vagas de empresas, levando em conta tanto **stack técnica** quanto **cultura**.

### Objetivos

- **Educação** – trilhas, módulos, vídeos e materiais de apoio.
- **Conexão** – empresas cadastrando vagas e talent pool.
- **Match inteligente** – pontuação baseada em tecnologias e cultura.
- **Reconhecimento** – emissão de certificados bonitos em PDF, prontos para baixar e compartilhar.

---

## ✨ Funcionalidades

### ✅ Já implementadas

**Autenticação & Perfis**
- Registro de **usuárias** e **empresas** (`/api/auth/register/*`).
- Login com **Laravel Sanctum** (API tokens) e endpoint `me`.
- Roles (`user` / `company`) com middleware de autorização.
- CRUD básico de usuárias e empresas, com filtros por `tech_stack` e `culture_tags`.

**Cursos, progresso e certificação**
- Modelos para `Course`, `Module`, `ModuleVideo`, `ModuleMaterial`.
- Serviço de progresso (`CourseProgressService`, `UserProgressService`).
- Marcar início e conclusão de curso/módulo.
- Jobs para side-effects ao concluir curso:
  - `UpdateTalentPoolStatus` (atualiza status no talent pool).
  - `SendCourseCompletedEmail` (envia e-mail de conclusão).
- **Certificado em PDF**:
  - Blade dedicado em `resources/views/certificates/course_certificate.blade.php`.
  - Download autenticado em
    `GET /api/auth/courses/{courseId}/certificate/download`.

**Sistema de E-mail**
- Templates HTML nas cores da Damas Tech em `resources/views/emails/*`:
  - Boas-vindas para usuária e empresa.
  - Atualização de progresso.
  - E-mail de envio de certificado.
- Mailables + Jobs (`SendWelcomeEmail`, `SendCourseCompletedEmail`).

**Match entre vagas e candidatas**
- `MatchService` calcula score entre usuária e vaga usando:
  - interseção de `tech_stack` (skills).
  - interseção de `culture_tags` (cultura).
- Endpoints:
  - Empresa vê candidatas ranqueadas: `GET /api/auth/company/jobs/{jobId}/matches`.
  - Usuária vê vagas recomendadas: `GET /api/auth/user/matches/jobs`.

**Documentação & Health**
- Health-check: `GET /api/health`.
- Documentação OpenAPI 3 única em: `docs/openapi.yaml`.
- Endpoint para servir o YAML: `GET /api/docs/openapi`.

**Infraestrutura & Deploy**
- Ambiente local com **SQLite** por padrão (arquivo `database.sqlite`).
- Dockerfile preparado para deploy (utilizado na Railway).
- Testes de feature e unitários rodando com `php artisan test`.

### 🚧 Em desenvolvimento

- Dashboard da empresa e da usuária com métricas agregadas.
- Sistema completo de Talent Pool (notas, histórico detalhado).
- Integração com gateways de pagamento (planos/assinaturas).

---

## 🛠 Tecnologias

**Backend**
- Laravel **12.x**
- PHP **^8.2**
- Banco de dados: **SQLite** (dev) / **MySQL** (produção)
- Sanctum (tokens de API)
- Queues para Jobs de e-mail e talent pool

**Qualidade**
- Pest para testes.
- PHP Insights (~90% de score) configurado em `config/insights.php`.

**Geração de PDF**
- `barryvdh/laravel-dompdf` para gerar certificados em PDF a partir de Blade.

**DevOps**
- Docker / Railway (deploy com imagem Docker custom).
- Composer / NPM.

---

## 💻 Ambiente Local

Pré-requisitos:

- PHP 8.2+
- Composer
- Git
- SQLite3 (ou MySQL se preferir)
- Node.js 18+ (para front/assets, se usar)

Instalação de PHP (exemplo Ubuntu):

```bash
sudo apt update
sudo apt install php8.2 php8.2-sqlite3 php8.2-mbstring php8.2-xml php8.2-curl php8.2-zip
```

---

## ⚡ Instalação Rápida

```bash
git clone https://github.com/Damas-Tech/api_damas_tech.git
cd api_damas_tech/damas-tech-app

composer install
npm install   # opcional, se for rodar front

cp .env.example .env
php artisan key:generate

php artisan migrate
php artisan serve
```

API local: `http://localhost:8000`

> Banco local: por padrão usa SQLite (`database/database.sqlite`).

---

## ⚙️ Configuração

Trecho importante do `.env` em desenvolvimento:

```env
APP_NAME="Damas Tech"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite

MAIL_MAILER=log
QUEUE_CONNECTION=database
```

Em produção (Railway), a API usa MySQL interno e SMTP real; as variáveis são configuradas direto no painel.

---

## 🔑 Fluxos Principais da API

### 1. Autenticação básica

Registrar usuária:

```bash
curl -X POST http://localhost:8000/api/auth/register/user \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Maria Silva",
    "email": "maria@example.com",
    "password": "senha123",
    "password_confirmation": "senha123"
  }'
```

Login e pegar token:

```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "maria@example.com",
    "password": "senha123"
  }'
```

Depois use o `token` retornado em qualquer rota protegida:

```bash
curl http://localhost:8000/api/auth/me \
  -H "Authorization: Bearer SEU_TOKEN_AQUI"
```

### 2. Progresso e certificado

Iniciar curso:

```bash
curl -X POST http://localhost:8000/api/auth/courses/1/start \
  -H "Authorization: Bearer SEU_TOKEN_AQUI"
```

Completar módulo:

```bash
curl -X POST http://localhost:8000/api/auth/modules/10/complete \
  -H "Authorization: Bearer SEU_TOKEN_AQUI"
```

Download do certificado (após concluir):

```bash
curl -X GET \
  http://localhost:8000/api/auth/courses/1/certificate/download \
  -H "Authorization: Bearer SEU_TOKEN_AQUI" \
  -o certificado-curso-1.pdf
```

### 3. Match entre vagas e candidatas

- Empresa vê candidatas ranqueadas para uma vaga:
  - `GET /api/auth/company/jobs/{jobId}/matches`
- Usuária vê vagas recomendadas para seu perfil:
  - `GET /api/auth/user/matches/jobs`

Todos esses endpoints estão documentados no OpenAPI (`docs/openapi.yaml`).

---

## 📁 Estrutura do Projeto

```text
damas-tech-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/       # Controladores da API
│   │   └── Middleware/        # Middlewares customizados
│   ├── Jobs/                  # Jobs (e-mails, talent pool)
│   ├── Mail/                  # Mailables
│   ├── Models/                # Modelos Eloquent
│   ├── Services/              # Regras de negócio (Auth, Match, Progresso...)
│   └── Support/               # Helpers (ErrorMessages, etc.)
├── config/
│   └── insights.php           # Configuração do PHP Insights
├── docs/
│   └── openapi.yaml           # Documentação OpenAPI 3
├── resources/
│   └── views/
│       ├── emails/            # Templates de e-mail
│       └── certificates/      # Layout do certificado em HTML
├── routes/
│   ├── api.php                # Rotas da API REST
│   └── web.php                # Rotas de preview e utilidades
├── tests/                     # Testes (Pest)
└── Dockerfile                 # Build de imagem para deploy
```

---

## 🧪 Qualidade e Boas Práticas

- **Testes**: `php artisan test`
- **Análise estática/estilo**: `php artisan insights`
- **Padrões**:
  - PSR-12, SOLID, DRY.
  - Controllers enxutos, regras de negócio em Services.
  - API Resources para respostas consistentes.

---

## 🤝 Contribuição

1. Faça um **fork** do projeto.
2. Clone o fork: `git clone https://github.com/seu-usuario/api_damas_tech.git`.
3. Crie uma branch: `git checkout -b feature/minha-feature`.
4. Implemente e garanta que os testes passam: `php artisan test`.
5. Abra um Pull Request explicando o contexto da mudança.

Padrão de commits sugerido (Conventional Commits):

```text
feat: nova funcionalidade
fix: correção de bug
docs: atualização de documentação
refactor: refatoração sem mudança de comportamento
test: adição/ajuste de testes
chore: tarefas de manutenção
```

---

## 📄 Licença

Projeto licenciado sob [MIT](LICENSE).

---

<div align="center">
  <p><strong>Damas Tech</strong> — educação, comunidade e oportunidades para mulheres na tecnologia.</p>
</div>