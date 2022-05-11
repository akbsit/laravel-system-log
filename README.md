# laravel-system-log, [Packagist](https://packagist.org/packages/falbar/laravel-system-log)

It is used for working with logging data, recording logs.

## Install

To install package, you need run command:

```bash
composer require falbar/laravel-system-log
```

## Examples

### Recording logs

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

#### Methods

* `setNameSpace($sNameSpace)` - specifying the read space:
    * `$sNameSpace` - name of the space (by default `default`).
* `enableSimpleInfo()` - enable minimum set of call location logging;
* `setInfo($arInfo)` - specifying information about the logging location:
    * `$arInfo` - array data.
* `setData($arData)` - specifying logging data:
    * `$arData` - array data.
* `setMessage($sMessage)` - specifying the logging message:
    * `$sMessage` - message.
* `setType($sType)` - specifying the logging type:
    * `$sType` - type (by default `error`).
* `put()` - create record.

### Reading logs

```php
use Falbar\SystemLog\SystemLog;

$oSystemLog = SystemLog::read()
    ->setNameSpace(SystemLog::NAMESPACE_API);
```

#### Methods

* `setNameSpace($sNameSpace)` - specifying the read space:
    * `$sNameSpace` - name of the space.
* `getSize()` - get the size of logs in space;
* `getAllSize()` - get the size of logs;
* `delete()` - clear logs in space;
* `deleteAll()` - clear logs;
* `getList()` - get a list of logs in the space.
