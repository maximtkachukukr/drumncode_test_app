## How setup:
Code is in the code folder.
1. docker-compose up -d, project will be here http://localhost. Db must be created authomatically
2. run composer install inside php container
3. run migrations
4. Get your token via API, or via `php artisan db:seed --class=UserSeeder` command - where will be message with created token
5. That's all
