[![Лицензия](https://img.shields.io/github/license/whiskyjs/bx-graphql-api?style=flat-square)](https://github.com/whiskyjs/bx-graphql-api/blob/develop/LICENSE.txt)

## BX-GraphQL-API

Модуль, реализующий расширяемый API на GraphQL в БУС.

Требует PHP 7.1 или выше и Composer.

Является зависимостью [bx-inspector](https://github.com/whiskyjs/bx-inspector).

### Но зачем?

![](https://i.imgur.com/QrxCvWn.png)

Помимо стандартных плюсов и минусов GraphQL по сравнению с, например, SOAP или JSON-RPC, модуль предоставляет фасады для методов библиотеки `machaon/std`, позволяющие элементарно реализовывать защищенный и типобезопасный двухсторонний обмен данными между различными площадками.

Например, это - локальный `getList()`:
```php
$rows = \Machaon\Std\IBlock\Query::getElements([
    "filter" => [
        "IBLOCK_ID" => 1,
        "ACTIVE" => "Y",
        "!PROPERTY_FLAG" => false,
    ],
    "page" => [
        "limit" => 10,
    ],
]);
```

А это - удалённый:
```php
$rows = \WJS\API\Facade\Machaon\Std\IBlock\Query::getElements([
    "filter" => [
        "IBLOCK_ID" => 1,
        "ACTIVE" => "Y",
        "!PROPERTY_FLAG" => false,
    ],
    "page" => [
        "limit" => 10,
    ],
    "endpoint" => [
        "url" => "http://host",
        "login" => "username",
        "password" => 'pa$$w0rd',
    ],
]);
```

Схема GraphQL и набор фасадов будут расширяться по мере необходимости.

### Установка

Находясь в `bitrix/modules`, вводим в терминале:

```bash
mkdir wjs.api && cd wjs.api && curl -L https://github.com/whiskyjs/bx-graphql-api/tarball/develop | tar xz && tmpdir=$(find . -maxdepth 1 -type d -name '[^.]?*' -printf %f -quit) && shopt -s dotglob && mv $tmpdir/* . && rmdir $tmpdir && composer install
```

Затем обычная установка через админку. Появится страница с опциями и GraphQL-запросом.

### Лицензия

Apache 2.0.
