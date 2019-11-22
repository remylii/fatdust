# EPG Thread

なしなし縛り

## Usage

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
    // ...

    $this->setView('some_method_view_filename');
    $this->setViewProps(["title" => "some method title"]);
}
```

## License

MIT
