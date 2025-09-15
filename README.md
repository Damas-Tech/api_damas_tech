# 🚀 Damas.Tech API

> Plataforma de educação tecnológica com foco em desenvolvimento de talentos e conexão entre empresas e profissionais.

[![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3+-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

## 📋 Índice

- [Sobre o Projeto](#sobre-o-projeto)
- [Funcionalidades](#funcionalidades)
- [Tecnologias](#tecnologias)
- [Pré-requisitos](#pré-requisitos)
- [Instalação](#instalação)
- [Configuração](#configuração)
- [Uso](#uso)
- [API Endpoints](#api-endpoints)
- [Estrutura do Projeto](#estrutura-do-projeto)
- [Status do Desenvolvimento](#status-do-desenvolvimento)
- [Boas Práticas](#boas-práticas)
- [Contribuição](#contribuição)
- [Licença](#licença)

## 🎯 Sobre o Projeto

A **Damas.Tech API** é uma plataforma educacional que conecta empresas e profissionais através de cursos de tecnologia. O sistema permite que empresas criem talent pools, usuários façam cursos e sejam avaliados, criando um ecossistema de desenvolvimento profissional.

### Principais Objetivos

- 🎓 **Educação**: Oferecer cursos de alta qualidade em tecnologia
- 🤝 **Conexão**: Conectar empresas com talentos qualificados
- 📊 **Avaliação**: Sistema de progresso e avaliação de competências
- 🚀 **Crescimento**: Impulsionar carreiras em tecnologia

## ✨ Funcionalidades

### ✅ Implementadas

- **Autenticação e Autorização**
  - Registro de usuários e empresas
  - Login com Sanctum (API tokens)
  - Sistema de roles (user/company)
  - Middleware de autorização por role

- **Gestão de Cursos**
  - Modelos para Course, Module, ModuleVideo, ModuleMaterial
  - Sistema de progresso de cursos
  - Tracking de conclusão de módulos

- **Sistema de Email**
  - Emails de boas-vindas
  - Notificações de conclusão de curso
  - Jobs para envio assíncrono

- **Infraestrutura**
  - Configuração SQLite para desenvolvimento
  - Migrations básicas
  - Estrutura de Models e relacionamentos

### 🚧 Em Desenvolvimento

- **Talent Pool**
  - Sistema de avaliação de candidatos
  - Status de progresso (in_training, highlighted)
  - Notas de avaliação

- **Sistema de Pagamentos**
  - Assinaturas e planos
  - Integração com gateways de pagamento
  - Histórico de pagamentos

- **Dashboard**
  - Painel para empresas
  - Painel para usuários
  - Relatórios de progresso

### 📋 Pendentes

- **Testes**
  - Testes unitários
  - Testes de integração
  - Testes de API

- **Documentação**
  - Swagger/OpenAPI
  - Documentação de endpoints

- **Segurança**
  - Rate limiting
  - Validação de entrada robusta
  - Logs de auditoria

## 🛠 Tecnologias

### Backend
- **Laravel 11.x** - Framework PHP
- **PHP 8.3+** - Linguagem de programação
- **SQLite** - Banco de dados (desenvolvimento)
- **Laravel Sanctum** - Autenticação API
- **Laravel Queue** - Processamento assíncrono

### Frontend (Futuro)
- **Vue.js/React** - Framework frontend
- **Tailwind CSS** - Framework CSS
- **Vite** - Build tool

### DevOps
- **Docker** - Containerização
- **GitHub Actions** - CI/CD
- **Composer** - Gerenciador de dependências

## 📋 Pré-requisitos

- PHP 8.3 ou superior
- Composer
- Git
- SQLite3 (ou MySQL/PostgreSQL para produção)
- Node.js 18+ (para assets frontend)

### Instalação das Dependências PHP

```bash
# Ubuntu/Debian
sudo apt update
sudo apt install php8.3 php8.3-sqlite3 php8.3-mbstring php8.3-xml php8.3-curl php8.3-zip

# macOS (com Homebrew)
brew install php@8.3

# Windows (usar XAMPP ou similar)
```

## 🚀 Instalação

### 1. Clone o Repositório

```bash
git clone https://github.com/Damas-Tech/api_damas_tech.git
cd api_damas_tech/damas-tech-app
```

### 2. Instale as Dependências

```bash
# Instalar dependências PHP
composer install

# Instalar dependências Node.js (opcional)
npm install
```

### 3. Configure o Ambiente

```bash
# Copiar arquivo de configuração
cp .env.example .env

# Gerar chave da aplicação
php artisan key:generate
```

### 4. Configure o Banco de Dados

O projeto está configurado para usar SQLite por padrão. O arquivo `database/database.sqlite` será criado automaticamente.

Para usar MySQL/PostgreSQL, edite o `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=damas_tech_app
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 5. Execute as Migrations

```bash
php artisan migrate
```

### 6. Inicie o Servidor

```bash
php artisan serve
```

A API estará disponível em `http://localhost:8000`

## ⚙️ Configuração

### Variáveis de Ambiente Importantes

```env
# Aplicação
APP_NAME="Damas.Tech"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Banco de Dados
DB_CONNECTION=sqlite
# DB_DATABASE=/caminho/para/database.sqlite

# Email (para produção)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu_email@gmail.com
MAIL_PASSWORD=sua_senha_app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@damas.tech"
MAIL_FROM_NAME="${APP_NAME}"

# Cache e Queue
CACHE_STORE=database
QUEUE_CONNECTION=database
```

## 📖 Uso

### Autenticação

#### Registrar Usuário
```bash
curl -X POST http://localhost:8000/api/auth/register/user \
  -H "Content-Type: application/json" \
  -d '{
    "name": "João Silva",
    "email": "joao@email.com",
    "password": "123456",
    "password_confirmation": "123456"
  }'
```

#### Registrar Empresa
```bash
curl -X POST http://localhost:8000/api/auth/register/company \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Tech Corp",
    "email": "contato@techcorp.com",
    "password": "123456",
    "password_confirmation": "123456",
    "cnpj": "12345678000199"
  }'
```

#### Login
```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "joao@email.com",
    "password": "123456"
  }'
```

## 🔗 API Endpoints

### Autenticação
- `POST /api/auth/register/user` - Registrar usuário
- `POST /api/auth/register/company` - Registrar empresa
- `POST /api/auth/login` - Login
- `POST /api/auth/logout` - Logout (requer token)

### Cursos (Em desenvolvimento)
- `GET /api/courses` - Listar cursos
- `POST /api/courses` - Criar curso (empresa)
- `GET /api/courses/{id}` - Detalhes do curso
- `POST /api/courses/{id}/start` - Iniciar curso

### Progresso
- `GET /api/progress/course/{id}` - Progresso do curso
- `POST /api/progress/module/{id}/complete` - Completar módulo

## 📁 Estrutura do Projeto

```
damas-tech-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # Controladores da API
│   │   └── Middleware/      # Middlewares customizados
│   ├── Models/              # Modelos Eloquent
│   ├── Services/            # Lógica de negócio
│   ├── Jobs/                # Jobs para filas
│   ├── Mail/                # Classes de email
│   └── Providers/           # Service Providers
├── database/
│   ├── migrations/          # Migrations do banco
│   └── seeders/             # Seeders para dados iniciais
├── resources/
│   └── views/
│       └── emails/          # Templates de email
├── routes/
│   └── api.php              # Rotas da API
└── tests/                   # Testes automatizados
```

## 📊 Status do Desenvolvimento

### ✅ Concluído (80%)

- [x] Estrutura base do Laravel
- [x] Sistema de autenticação
- [x] Modelos principais (User, Company, Course, Module)
- [x] Sistema de roles e middleware
- [x] Templates de email
- [x] Jobs para processamento assíncrono
- [x] Configuração de desenvolvimento

### 🚧 Em Progresso (15%)

- [ ] Sistema de Talent Pool
- [ ] Dashboard de empresas
- [ ] Sistema de pagamentos
- [ ] Documentação da API

### 📋 Pendente (5%)

- [ ] Testes automatizados
- [ ] Deploy e CI/CD
- [ ] Monitoramento e logs
- [ ] Documentação completa

## 🎯 Boas Práticas

### Código

- **PSR-12**: Seguir padrões de codificação PHP
- **SOLID**: Princípios de design orientado a objetos
- **DRY**: Don't Repeat Yourself
- **Nomenclatura**: Usar nomes descritivos em inglês

### Git

- **Commits**: Mensagens claras e descritivas
- **Branches**: Feature branches para novas funcionalidades
- **Pull Requests**: Sempre revisar código antes de merge
- **Conventional Commits**: Usar padrão de commits

### Laravel

- **Controllers**: Manter controllers enxutos
- **Services**: Lógica de negócio em Services
- **Resources**: Usar API Resources para responses
- **Validation**: Validação robusta de entrada
- **Middleware**: Usar middleware para cross-cutting concerns

### Segurança

- **Sanitização**: Sempre sanitizar entrada do usuário
- **Autorização**: Verificar permissões em todas as rotas
- **Rate Limiting**: Implementar limites de requisições
- **HTTPS**: Usar HTTPS em produção
- **Secrets**: Nunca commitar credenciais

### Performance

- **Eager Loading**: Evitar N+1 queries
- **Caching**: Cache de queries frequentes
- **Indexes**: Índices apropriados no banco
- **Queue**: Operações pesadas em background

## 🤝 Contribuição

### Como Contribuir

1. **Fork** o projeto
2. **Clone** seu fork: `git clone https://github.com/seu-usuario/api_damas_tech.git`
3. **Crie** uma branch: `git checkout -b feature/nova-funcionalidade`
4. **Commit** suas mudanças: `git commit -m 'feat: adiciona nova funcionalidade'`
5. **Push** para a branch: `git push origin feature/nova-funcionalidade`
6. **Abra** um Pull Request

### Padrões de Commit

```
feat: nova funcionalidade
fix: correção de bug
docs: documentação
style: formatação
refactor: refatoração
test: testes
chore: tarefas de manutenção
```

### Checklist para PR

- [ ] Código segue padrões PSR-12
- [ ] Testes passando
- [ ] Documentação atualizada
- [ ] Sem conflitos de merge
- [ ] Commits com mensagens claras

## 📄 Licença

Este projeto está licenciado sob a Licença MIT - veja o arquivo [LICENSE](LICENSE) para detalhes.

## 👥 Equipe

- **Desenvolvimento**: Equipe Damas.Tech
- **Contato**: contato@damas.tech

## 📞 Suporte

- **Issues**: [GitHub Issues](https://github.com/Damas-Tech/api_damas_tech/issues)
- **Email**: suporte@damas.tech
- **Discord**: [Servidor da Comunidade](https://discord.gg/damastech)

---

<div align="center">
  <p>Feito com ❤️ pela equipe Damas.Tech</p>
  <p>🚀 Impulsionando carreiras em tecnologia</p>
</div>