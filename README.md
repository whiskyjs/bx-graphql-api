[![Лицензия](https://img.shields.io/github/license/whiskyjs/bx-graphql-api?style=flat-square)](https://github.com/whiskyjs/bx-graphql-api/blob/develop/LICENSE.txt)

## BX-GraphQL-API

Модуль, реализующий расширяемый API на GraphQL в БУС.

Требует PHP 7.2 или выше.

Является зависимостью [bx-inspector](https://github.com/whiskyjs/bx-inspector).

### Установка

Из папки bitrix/modules в терминале:

```bash
curl -L https://github.com/whiskyjs/bx-graphql-api/tarball/develop | tar xz && mv $(find . -maxdepth 1 -type d -name '[^.]?*' -printf %f -quit) wjs.api
```

Затем установка через админку.

### Лицензия

Apache 2.0.
