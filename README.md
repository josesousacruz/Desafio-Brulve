# Brulve App FastLog

Aplicação de logística desenvolvida com o framework Laravel.

## Requisitos

**Para ambiente de Desenvolvimento Local:**
* PHP 8.4.6 (cli) (built: Apr 10 2025 22:22:10) (NTS)
* Composer
* Node.js e NPM
* Servidor MySQL (ou compatível) rodando na porta 3306 com banco de dados 'appfastlog' criado
* Git

**Para ambiente Docker :**
* Docker
* Docker Compose

## Instalação e Execução
### Desenvolvimento Local

1.  **Clone o repositório:**
    ```bash
    git clone https://gitlab.com/desafiobrulve/Fastlog
    cd appFastlog
    ```

2.  **Copie e configure o arquivo de ambiente:**
    ```bash
    cp .env-example .env
    ```
    * **Importante:** Edite o arquivo `.env` e ajuste as variáveis de conexão com o banco de dados (`DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`) para corresponder à sua configuração local do MySQL.

3.  **Instale as dependências do PHP:**
    ```bash
    composer install
    ```

4.  **Instale as dependências do Node.js:**
    ```bash
    npm install
    ```

5.  **Gere a chave da aplicação Laravel:**
    ```bash
    php artisan key:generate
    ```

6.  **Execute as migrações do banco de dados:**
    Certifique-se de que seu servidor MySQL local esteja rodando e o banco de dados (`appfastlog` por padrão no `.env-example`) exista.
    ```bash
    php artisan migrate
    ```
    * Você pode adicionar `--seed` se tiver seeders para popular o banco.

7.  **Inicie o servidor de desenvolvimento do Laravel:**
    ```bash
    php artisan serve
    ```
    * A aplicação estará disponível em [http://localhost:8000](http://localhost:8000).

8.  **Compile os assets ou inicie o servidor Vite:**
    * Para desenvolvimento com Hot Module Replacement (HMR):
        ```bash
        npm run dev
        ```
    * Para gerar os arquivos de produção (geralmente não necessário para desenvolvimento):
        ```bash
        npm run build
     ```


### Usando Docker 

1.  **Clone o repositório:**
    ```bash
    git clone https://gitlab.com/desafiobrulve/Fastlog
    ```

2.  **Entre na pasta do projeto Laravel e instale as dependências:**
    ```bash
    cd appFastlog
    composer install
    npm install
    ```

3.  **Volte para o diretório raiz onde está o docker-compose.yml:**
    ```bash
    cd ..
    ```

4.  **Copie o arquivo de ambiente:**
    O arquivo `.env-example` já contém as configurações necessárias para o ambiente Docker.
    ```bash
    cp appFastlog/.env-example appFastlog/.env
    ```

5.  **Construa e suba os containers:**
    Este comando irá baixar as imagens necessárias e iniciar os serviços (aplicação Laravel, servidor Vite e banco de dados MySQL).
    ```bash
    docker-compose up -d --build
    ```

4.  **Execute as migrações do banco de dados:**
    Após os containers estarem rodando, execute as migrações manualmente dentro do container da aplicação:
    ```bash
    docker-compose exec app php artisan migrate
    ```
    * Você pode adicionar `--seed` se tiver seeders para popular o banco: `docker-compose exec app php artisan migrate --seed`

5.  **Acesse a aplicação:**
    * Aplicação Laravel: [http://localhost:8000](http://localhost:8000)
    * Servidor de desenvolvimento Vite (HMR): [http://localhost:5173](http://localhost:5173) (geralmente acessado através da aplicação principal)
    * Banco de dados MySQL: Acessível em `localhost:3306` (host `mysql` de dentro do container da aplicação).

6.  **Para parar os containers:**
    ```bash
    docker-compose down
    ```

## Usuário Padrão do Sistema

Para acessar o sistema, utilize as seguintes credenciais:

* **Email:** teste@example.com
* **Senha:** password

## Fluxo do Sistema

O sistema opera com o seguinte fluxo de trabalho:

1. **Criação do Motorista de Entrega**
   - Criar um perfil de entregador
   - Especificar o tipo de veículo que será utilizado

2. **Criação do Pedido**
   - Preencher todos os campos obrigatórios
   - Importante: Especificar o tipo de veículo necessário para a entrega

3. **Atribuição do Pedido**
   - Pedidos só podem ser atribuídos a Entregadores disponíveis
   - O tipo de veículo do motorista deve corresponder ao tipo de veículo exigido pelo pedido
   - Entregadores que estão em uma entrega não podem receber novos pedidos

Requisitos Principais:
- O entregador deve ter o tipo de veículo correspondente para atribuição do pedido
- O entregador deve estar disponível (não estar em uma entrega ativa)
- Todos os campos obrigatórios devem ser preenchidos ao criar pedidos

## Versões Utilizadas

* **PHP:** 8.4.6 (cli) (built: Apr 10 2025 22:22:10) (NTS)
* **Laravel Framework:** 12.10.2

## Observações Adicionais

* O método preferencial para rodar o projeto é via Docker, pois garante a consistência do ambiente e simplifica a configuração inicial.
* **Importante:** As migrações do banco de dados (`php artisan migrate`) devem ser executadas manualmente após iniciar os containers Docker pela primeira vez ou sempre que houver novas migrações.
* O container Docker `app` automaticamente executa `composer install`, `npm install`, `npm run dev` e `php artisan serve --host=0.0.0.0` ao ser iniciado.
* As portas expostas pelo Docker são:
    * `8000`: Servidor de desenvolvimento do Laravel (`php artisan serve`)
    * `5173`: Servidor de desenvolvimento do Vite (`npm run dev`)
    * `3306`: Servidor MySQL
* O arquivo `.env-example` contém as credenciais padrão para o banco de dados MySQL no ambiente Docker (`DB_HOST=mysql`, `DB_DATABASE=appfastlog`, `DB_USERNAME=root`, `DB_PASSWORD=localdeveloper`).

## Documentação da API

A documentação completa da API está disponível através do Swagger UI em:
* [http://localhost:8000/api/documentation](http://localhost:8000/api/documentation)

