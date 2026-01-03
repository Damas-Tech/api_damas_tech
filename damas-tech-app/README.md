<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Damas Tech Logo">
</p>

<h1 align="center">Damas Tech - API</h1>

<p align="center">
    <img src="https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php" alt="PHP Badge">
    <img src="https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel" alt="Laravel Badge">
    <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql" alt="MySQL Badge">
    <img src="https://img.shields.io/badge/OpenAPI-3.0-6BA539?style=for-the-badge&logo=openapi-initiative" alt="OpenAPI Badge">
</p>

---

## 🚀 Sobre o Projeto

**Damas Tech** é uma plataforma focada na **Educação e Empregabilidade** para mulheres na tecnologia. Esta API RESTful alimenta toda a inteligência do sistema, gerenciando desde o aprendizado (LMS) até a conexão com vagas de emprego.

A plataforma não apenas entrega conteúdo, mas oferece uma experiência prática com um **Code Runner** integrado, fórum de comunidade e sistema gamificado de certificação.

## ✨ Funcionalidades Principais

### 🎓 LMS (Learning Management System)
- **Trilhas de Aprendizado:** Cursos estruturados em módulos e materiais (Vídeos, PDFs, Artigos).
- **Projetos Práticos:** Submissão de projetos reais com feedback (GitHub/Deploy).
- **Certificados Dinâmicos:** Geração automática de certificados em PDF ao concluir cursos ou projetos.
- **Progresso Detalhado:** Acompanhamento visual da evolução da estudante (%) por curso e módulo.

### 💻 Code Runner & Playground
- **Executor Multilinguagem:** Integração com API Piston para execução segura de código.
- **Linguagens Suportadas:** Python, JavaScript, PHP, Java, Go, C++, etc.
- **Code Challenges:** Desafios de programação com validação automática de output (estilo LeetCode).

### 🤝 Comunidade & Social
- **Fórum de Dúvidas:** Criação de tópicos e respostas, vinculados ou não a cursos específicos.
- **Login Social:** Autenticação simplificada com Google Account (OAuth2).

### 🏢 Portal de Empregabilidade
- **Match de Vagas:** Algoritmo que conecta candidatas a vagas baseando-se em Tech Stack, Cultura e Senioridade.
- **Dashboard para Empresas:** Métricas de visualização de vagas e perfil de candidatas.
- **Candidatura Simplificada:** Aplicação para vagas com um clique.

### 🛡️ Segurança & Infraestrutura
- **Autenticação Robusta:** Tokens via Laravel Sanctum com expiração e rotação automática.
- **Rate Limiting:** Proteção contra força bruta em logins e abuso do Code Runner.
- **Password Policies:** Exigência de senhas fortes e compromissadas (HIBP).
- **Filas & Jobs:** Envio assíncrono de e-mails de boas-vindas, reset de senha e suporte.

---

## 🛠️ Tecnologias Utilizadas

- **Framework:** Laravel 11
- **Banco de Dados:** MySQL / SQLite (Dev)
- **Autenticação:** Laravel Sanctum & Socialite (Google)
- **Documentação:** OpenAPI 3.0 (Swagger UI)
- **PDFs:** DomPDF
- **Jobs/Queue:** Database Driver

---

## ⚙️ Instalação e Configuração

### Pré-requisitos
- PHP >= 8.2
- Composer
- MySQL

### Passo a Passo

1. **Clone o repositório:**
   ```bash
   git clone git@github.com:seu-usuario/api-damas-tech.git
   cd damas-tech-app
   ```

2. **Instale as dependências:**
   ```bash
   composer install
   ```

3. **Configure as variáveis de ambiente:**
   ```bash
   cp .env.example .env
   # Edite o .env com suas configurações de DB e E-mail
   ```

4. **Gere a chave da aplicação:**
   ```bash
   php artisan key:generate
   ```

5. **Execute as migrações (com seeders opcionais):**
   ```bash
   php artisan migrate --seed
   ```

6. **Inicie o servidor:**
   ```bash
   php artisan serve
   ```

A API estará disponível em `http://localhost:8000`.

---

## 📚 Documentação da API

A documentação completa dos endpoints está disponível via **Swagger UI**.

- **Acesse:** `http://localhost:8000/docs`
- **Arquivo YAML:** Disponível em `docs/openapi.yaml`

---

## 🧪 Testando Funcionalidades

### Code Runner
Para testar o executor de código:
```http
POST /api/auth/code/execute
{
    "language": "python",
    "code": "print('Hello Damas Tech!')"
}
```

### Reset de Senha
Para simular o fluxo de "Esqueci minha senha" em ambiente local, utilize o endpoint `/api/auth/forgot-password`. O e-mail enviado contanrá um link para o frontend (configurável no `.env`).

---

## 📄 Licença

Este projeto está sob a licença [MIT](https://opensource.org/licenses/MIT).

---

<p align="center">Desenvolvido com 💜 por <strong>Andressa Silva Pereira</strong> - CTO Damas Tech</p>
