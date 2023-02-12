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

# serve at localhost:80
    $ cd path/to/your/app php -S 127.0.0.1:80



# API endpoints
   - First login:
      - /login - POST [cpf, senha] will return token. Put token in API Key Auth Header with key "token"

   - GET /pedidos_finalizados will return all finalized orders

   Insomina Collection: Insomnia-aplicativo-teste.json file in project root
   
