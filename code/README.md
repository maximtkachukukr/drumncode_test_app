## About Project
Technical spec https://docs.google.com/document/d/1g_6R0n4DS6rTyWS1BciNdREfJl2oA2qst04tE5c5CLo/edit?usp=sharing 

basically implements REST API for tasks CRUD

## How setup:
1. docker-compose up -d, project will be here http://localhost. Db must be created authomatically
2. run composer install inside php container
3. run migrations
4. Get your token via API, or via `php artisan db:seed --class=UserSeeder` command - where will be message with created token
5. That's all

## OpenApi:
Url to OpenApi http://localhost/openapi


## What's left
- implement Search criteria for repositories
- Use Laravel Scout for searching, because searching in mysql is slow
- Need QA help
