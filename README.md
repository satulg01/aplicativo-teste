Simple crud based in Codeigniter 3 

# aplicativo-teste

Requires PHP 7.4


# Build Setup

 - Enable php.ini extensions:

    - extension=mysqli


 - Install dependencies
    - $ composer update

 - Create .env file
    - cp .env.example .env [Linux]
    - copy .env.example .env [Windows]

 - Create database and import sql file in project root

 - Config database infos in .env 

# serve at localhost:80
    $ cd path/to/your/app php -S 127.0.0.1:80


# Initial user and password:
   - User: 999.999.999-99
   - Pass: 123


# API endpoints
   - First login:
      - /login - POST [cpf, senha] will return token. Put token in API Key Auth Header with key "token"

   - GET /pedidos_finalizados will return all finalized orders

   Insomina Collection: Insomnia-aplicativo-teste.json file in project root

# Funções do sistema
   - Colaboradores inseridos como fornecedor não tem acesso ao sistema.
   - Colaboradores inseridos como usuário mas com acesso de vendedor somente acessa a área de pedidos e apenas visualiza e adiciona, não edita.

   - Se caso errar a senha 3 vezes, tomará block de 10min. Esse tempo não é zerado.
