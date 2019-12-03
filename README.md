# EPG Thread

なしなし縛り

## Usage

```
# build-in web server
$ composer start

# use docker-compose.  localhost:8001
$ docker-compose build
$ docker-compose up
```

## Configuration

### DB settings

create `Infrastructure/config.php` .
config.example.php is example.

### Routing

```php
//   HTTP_METHOD,  Path,  Action.method
$routing_map = [
        ["GET",  "/",     "index"],
        ["POST", "/post", "store"],
    ];
```

### Action

```php
function someMethod()
{
  return new TemplateResponse();
}
```

## Migrations

This is work only create `.sql` file. If you use db, you execute file yourself.

```
$ ./migrations/create.sql {table_name}
```

## License

MIT
