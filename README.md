# crudcmd

## Dependencia

Para usar esse pacote você precisa do pacote `semge/core`

#### Usando

`composer require gwmoura/crudcmd`

Criando um crud simples

`./vendor/bin/crudcmd crud:create laravel Post`

#### Arquivos gerados

* app/Models/Post
* app/Http/Controllers/PostController
* app/Repositories/PostRepository
* database/factories/PostFactory
* database/migrations/*_create_post_table
* resources/views/post/[index, create, edit, show]
