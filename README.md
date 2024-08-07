# Tiny ERP Client (API v2)

```php
$client = new Client('token');

$retorno = $client->info()->get();
$entity = $retorno->data();
echo $entity->razao_social;
```


```php
$retorno = $client->produto()->retrieve(349112581);
$entity = $retorno->data();
echo $entity->nome;
```