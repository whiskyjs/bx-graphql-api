[![Лицензия](https://img.shields.io/github/license/whiskyjs/bx-graphql-api?style=flat-square)](https://github.com/whiskyjs/bx-graphql-api/blob/develop/LICENSE.txt)

## BX-GraphQL-API

Модуль, реализующий расширяемый API на GraphQL в БУС.

Требует PHP 7.1 или выше и Composer.

Является зависимостью [bx-inspector](https://github.com/whiskyjs/bx-inspector).

### Установка

Находясь в `bitrix/modules`, вводим в терминале:

```bash
mkdir wjs.api && cd wjs.api && curl -L https://github.com/whiskyjs/bx-graphql-api/tarball/develop | tar xz && tmpdir=$(find . -maxdepth 1 -type d -name '[^.]?*' -printf %f -quit) && shopt -s dotglob && mv $tmpdir/* . && rmdir $tmpdir && composer install
```

Затем обычная установка через админку. Появится страница с опциями и GraphQL-запросом.

### Лицензия

Apache 2.0.
