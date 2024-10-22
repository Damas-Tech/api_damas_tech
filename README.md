# API Damas Tech
 # Projeto API - Gestão de Biblioteca

Bem-vindo ao projeto de API para gestão de uma biblioteca! Este projeto foi desenvolvido utilizando Django REST Framework e SQLite3, com o objetivo de criar uma API robusta e escalável para gerenciar informações de livros, autores e usuários da biblioteca.

## Sumário

- [Sobre o Projeto](#sobre-o-projeto)
- [Tecnologias Utilizadas](#tecnologias-utilizadas)
- [Instalação e Configuração](#instalação-e-configuração)
- [Endpoints Principais](#endpoints-principais)
- [Como Contribuir](#como-contribuir)
- [Equipe](#equipe)
- [Links Úteis](#links-úteis)

## Sobre o Projeto

O projeto de API de Gestão de Biblioteca tem como objetivo fornecer uma plataforma eficiente para o gerenciamento de livros, autores e usuários de uma biblioteca. Utilizando Django REST Framework, a API oferece funcionalidades como cadastro, edição e exclusão de livros, além de autenticação de usuários. O banco de dados utilizado é o SQLite3, garantindo simplicidade e agilidade no desenvolvimento.

### Funcionalidades principais:
- CRUD de livros (criar, listar, editar, excluir)
- Gerenciamento de autores
- Cadastro e autenticação de usuários
- Filtragem e pesquisa de livros por título e autor

## Tecnologias Utilizadas

- **[Django 5.1](https://www.djangoproject.com/)** - Framework web para o backend.
- **[Django REST Framework](https://www.django-rest-framework.org/)** - Biblioteca para a criação de APIs RESTful com Django.
- **[SQLite3](https://www.sqlite.org/index.html)** - Banco de dados utilizado no projeto.
- **[Python 3.12.5](https://www.python.org/)** - Linguagem de programação.
- **[Docker](https://www.docker.com/)** (opcional) - Para containerização do ambiente de desenvolvimento.

## Instalação e Configuração

1. Clone o repositório:
    ```bash
    git clone https://github.com/seu-usuario/seu-projeto.git
    cd seu-projeto
    ```

2. Crie e ative um ambiente virtual (opcional, mas recomendado):
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

## Endpoints Principais

Abaixo estão alguns dos principais endpoints da API:

- **/api/books/** - Endpoint para listar ou criar novos livros.
- **/api/books/{id}/** - Endpoint para visualizar, atualizar ou excluir um livro específico.
- **/api/authors/** - Endpoint para listar ou criar autores.
- **/api/users/** - Gerenciamento de usuários (registro, login).

Para mais detalhes sobre todos os endpoints, consulte a [Documentação da API](#links-úteis).

## Como Contribuir

1. Faça um fork do projeto
2. Crie uma nova branch:
    ```bash
    git checkout -b minha-nova-feature
    ```
3. Faça suas modificações e faça o commit:
    ```bash
    git commit -m 'Adiciona nova feature'
    ```
4. Envie para o repositório remoto:
    ```bash
    git push origin minha-nova-feature
    ```
5. Abra um Pull Request para análise.

## Equipe

- **Desenvolvedor Backend**: [Seu Nome](https://github.com/seu-usuario)
- **Gerente de Projeto**: [Nome do Gerente](https://www.linkedin.com/in/nome-do-gerente/)
- **Testes e QA**: [Nome QA](https://www.linkedin.com/in/nome-do-qa/)

## Links Úteis

- [Jira do Projeto](https://seu-projeto-jira-link.com)
- [Documentação da API - Postman](https://link-postman-documentacao.com)
- [Django REST Framework](https://www.django-rest-framework.org/)
- [Documentação do Django](https://docs.djangoproject.com/)

## Licença

Este projeto está licenciado sob a [MIT License](https://opensource.org/licenses/MIT) - veja o arquivo LICENSE para mais detalhes.

## Sugestões Finais

- **Testes Automatizados**: O projeto já inclui alguns testes com Pytest. É recomendável expandir a cobertura de testes conforme o desenvolvimento.
- **Deploy com Docker**: Para ambientes de produção, recomenda-se o uso de containers Docker para facilitar o deploy. Verifique o arquivo `Dockerfile` para mais detalhes.
- **Segurança**: Certifique-se de configurar variáveis de ambiente para armazenar dados sensíveis, como chaves secretas e credenciais de banco de dados.

---

Desenvolvido com 💻 por [Seu Nome](https://github.com/seu-usuario).

