# laravel-system-log, [Packagist](https://packagist.org/packages/falbar/laravel-system-log)

Используется для работы c данными логирования, записи логов.

## Установка

Для установки пакета нужно:

```bash
composer require falbar/laravel-system-log
```

## Примеры использования

### Запись логов

```php
use Falbar\SystemLog\SystemLog;

$arData = [
    'some_data' => 1
];

SystemLog::write()
    ->enableSimpleInfo()
    ->setInfo(['method' => __METHOD__])
    ->setData(['$arData' => $arData])
    ->setMessage('Some log message')
    ->put();
```

#### Список методов

* `setNameSpace($sNameSpace)` - указание пространства для чтения:
    * `$sNameSpace` - название пространства (по умолчанию `default`).
* `enableSimpleInfo()` - включить логирование места вызова;
* `setInfo($arInfo)` - указание информации о месте логирования:
    * `$arInfo` - массив данных.
* `setData($arData)` - указание данных логирования:
    * `$arData` - массив данных.
* `setMessage($sMessage)` - указание сообщения логирования:
    * `$sMessage` - сообщение.
* `setType($sType)` - указание типа логирования:
    * `$sType` - тип (по умолчанию `error`).
* `put()` - создать запись.

### Чтение логов

```php
use Falbar\SystemLog\SystemLog;

$oSystemLog = SystemLog::read()
    ->setNameSpace(SystemLog::NAMESPACE_API);
```

#### Список методов

* `setNameSpace($sNameSpace)` - указание пространства для чтения:
    * `$sNameSpace` - название пространства.
* `getSize()` - получить размер логов в пространстве;
* `getAllSize()` - получить размер логов;
* `delete()` - очистить логи в пространстве;
* `deleteAll()` - очистить логи;
* `getList()` - получить список логов в пространстве.
