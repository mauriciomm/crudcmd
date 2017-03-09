# crudcmd

## Dependencia

Para usar esse pacote você precisa do pacote `semge/core`

#### Usando

`composer require gwmoura/crudcmd:dev-master`

Copie os templates

`./vendor/bin/crudcmd template:copy laravel`

Criando um crud simples

`./vendor/bin/crudcmd crud:create laravel Post`

#### Arquivos gerados

* app/Models/Post
* app/Http/Controllers/PostController
* app/Repositories/PostRepository
* database/factories/PostFactory
* database/migrations/*_create_post_table
* resources/views/post/[index, create, edit, show]

Adicione `Route::resource('post', 'PostController')` no `routes/web.php`
Adicione os campos do post na migration
Execute `php artisan migrate`
Execute `php artisan serve` e acesse `http://localhost:8000`
