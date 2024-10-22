# 🚀 Projeto API - Damas Tech

<img src="https://github.com/user-attachments/assets/7d01dd3e-ef36-4b8d-9063-286a73c608ae" alt="Texto alternativo" width="300" height="300">


O **Damas Tech** é uma iniciativa que visa promover a inclusão de mulheres no mercado de trabalho, oferecendo programas de treinamento e bootcamps em parceria com empresas. A API desenvolvida permitirá a gestão de informações relacionadas aos programas, empresas parceiras e participantes, criando uma plataforma de conexão entre as mulheres e oportunidades profissionais.


## 📚 Sumário

- [Sobre o Projeto](#sobre-o-projeto)
- [Tecnologias Utilizadas](#tecnologias-utilizadas)
- [Instalação e Configuração](#instalação-e-configuração)
- [Endpoints Principais](#endpoints-principais)
- [Como Contribuir](#como-contribuir)
- [Equipe](#equipe)
- [Links Úteis](#links-úteis)
- [Dashboard](#dashboard)
- [Licença](#licença)

## 💡 Sobre o Projeto

O projeto **Damas Tech** busca conectar mulheres ao mercado de trabalho por meio de programas de capacitação e treinamento desenvolvidos em parceria com empresas de diversos setores. A API será a base para gerenciar:

- 🎓 Inscrições de participantes nos programas.
- 🏢 Informações sobre os bootcamps disponíveis.
- 🤝 Parcerias com empresas que oferecem oportunidades de contratação para mulheres treinadas no Damas Tech.

### 🎯 Objetivos do projeto:
1. Facilitar o acesso a programas de treinamento focados no público feminino.
2. Conectar empresas com participantes qualificadas para o mercado de trabalho.
3. Gerenciar informações sobre inscrições, programas e status de conclusão de cursos.

### 🔑 Funcionalidades principais:
- ✅ Cadastro e autenticação de usuárias.
- ✅ Cadastro e autenticação de empresas.

## 🛠️ Tecnologias Utilizadas

- **[Django 5.1](https://www.djangoproject.com/)** - Framework web para o backend.
- **[Django REST Framework](https://www.django-rest-framework.org/)** - Biblioteca para a criação de APIs RESTful com Django.
- **[SQLite3](https://www.sqlite.org/index.html)** - Banco de dados utilizado no projeto.
- **[Python 3.12.5](https://www.python.org/)** - Linguagem de programação.
- **[Docker](https://www.docker.com/)** (opcional) - Para containerização do ambiente de desenvolvimento.
- **[Pytest](https://docs.pytest.org/en/7.1.x/)** - Ferramenta para testes automatizados.

## 📥 Instalação e Configuração

1. Clone o repositório:
    ```bash
    git clone https://github.com/Damas-Tech/api_damas_tech.git
    cd api_damas_tech
    ```

2. Crie e ative um ambiente virtual (opcional):
    ```bash
    python -m venv venv
    source venv/bin/activate  # No Linux/MacOS
    venv\Scripts\activate  # No Windows
    ```

3. Instale as dependências:
    ```bash
    pip install -r requirements.txt
    ```

4. Execute as migrações do banco de dados:
    ```bash
    python manage.py migrate
    ```

5. Inicie o servidor de desenvolvimento:
    ```bash
    python manage.py runserver
    ```

## 🌳 Estratégia de Branches

Para garantir um fluxo de trabalho eficiente e colaborativo, utilizamos uma estratégia de branches na organização **Damas Tech**. A principal branch para desenvolvimento é a `develop`, que será utilizada para o desenvolvimento tanto do frontend quanto do backend. 

### 🏗️ Fluxo de Trabalho:

1. **Branch Principal**:
   - `develop`: Branch onde todas as novas funcionalidades e correções de bugs são integradas. É a base para os desenvolvimentos do frontend e backend.

2. **Criação de Branches de Funcionalidades**:
   - Ao iniciar uma nova feature ou correção, crie uma nova branch a partir da `develop`:
     ```bash
     git checkout develop
     git checkout -b minha-nova-feature
     ```

3. **Merge e Pull Request**:
   - Após concluir o desenvolvimento na branch da funcionalidade, faça um pull request para a `develop` para revisão e integração.

4. **Sincronização**:
   - Mantenha sua branch atualizada com a `develop` para evitar conflitos:
     ```bash
     git checkout develop
     git pull origin develop
     git checkout minha-nova-feature
     git rebase develop
     ```

## 📌 Endpoints Principais

Abaixo estão alguns dos principais endpoints da API:

- **GET /api/programs/** - Listar todos os programas disponíveis.
- **POST /api/programs/** - Criar um novo programa.
- **GET /api/partners/** - Listar empresas parceiras.
- **POST /api/partners/** - Cadastrar uma nova empresa parceira.
- **POST /api/signup/** - Registrar uma nova usuária.

Para mais detalhes sobre todos os endpoints, consulte a [Documentação da API](#links-úteis).

## 👩‍💻 Equipe

- **Desenvolvedora Backend**: [Andressa Silva](https://github.com/AndressaSilva0) 🌟
- **Desenvolvedor Backend**: [Jonathan Júnior](https://github.com/Jonhyyplay) 🌟
- **Desenvolvedor Backend**: [Erick Vinicius](https://github.com/EriiSy) 🌟
- **Scrum Master**: [Aloisio Gonçalves](https://github.com/Aloisio-Doerl) 🌟

## 🔗 Links Úteis

- [API Damas Tech - GitHub](https://github.com/Damas-Tech/api_damas_tech/)
- [Front Damas Tech - GitHub](https://github.com/Damas-Tech/fronten_damas_tech/)
- [Jira do Projeto](https://damastech.atlassian.net/jira/people/team/cfb1ad1f-4d03-4470-bf40-58ff1017b1a0)
- [Documentação da API - Postman](https://link-postman-documentacao.com)
- [Django REST Framework](https://www.django-rest-framework.org/)
- [Documentação do Django](https://docs.djangoproject.com/)

## Dashboard
  ## Estatísticas
* **Issues:** [![GitHub issues](https://img.shields.io/github/issues/Damas-Tech/api_damas_tech.svg)](https://github.com/Damas-Tech/api_damas_tech/issues)
* **Pull Requests:** [![GitHub pull requests](https://img.shields.io/github/pulls/Damas-Tech/api_damas_tech.svg)](https://github.com/Damas-Tech/api_damas_tech/pulls)

## Status do Projeto
* **Build:** [![CI/CD pipeline status](https://github.com/Damas-Tech/api_damas_tech/actions/workflows/main.yml/badge.svg)](https://github.com/Damas-Tech/api_damas_tech/actions)
* **Cobertura de código:** [![codecov](https://codecov.io/gh/Damas-Tech/api_damas_tech/branch/main/graph/badge.svg?token=YOUR_TOKEN)](https://codecov.io/gh/Damas-Tech/api_damas_tech)

## 📝 Licença

Este projeto está licenciado sob a [MIT License](https://opensource.org/licenses/MIT) - veja o arquivo LICENSE para mais detalhes.

---

Desenvolvido com 💻 por [Andressa Silva](https://github.com/AndressaSilva0).
