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

 - Create database and import sql file on project root

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

# System functions
   - Collaborators entered as a supplier don't have access to the system.
   - Collaborators entered as a user but with seller access only access the order area and only view and add, not edit..

   - If you put wrong password 3 times, will be blocked for 10 minutes. This time not reset, just later the time .
			
   - New collaborators come with the default password '123'
