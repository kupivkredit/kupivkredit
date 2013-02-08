Базовое использование
================================

Загрузка классов
--------------------------------

Файловая структура и именование классов Библиотеки организованы в соответствии со стандартом [PSR-0][0]. Это означает,
что классы Библиотеки используют [пространства имен][1], и поэтому, для их использования в первую очередь необходимо
воспользоваться оператором [use][2]:

`use Kupivkredit\Kupivkredit;`

Однако, чтобы использовать класс Kupivkredit, необходимо, чтобы файл содержащий данный класс был подключен и исполнен.

Есть несколько способов это сделать:

    *   Автоматическая загрузка классов загрузчиком composer.
        Если вы установили Библиотеку КупиВкредит через composer, достаточно подключить стандартный автозагрузчик классов,
        создаваемый в момент инсталляции пакетов:

        `require_once 'path/to/composer/vendor/autoload.php';`

    *   Автоматическая загрузка классов вашим загрузчиком.
        Если у вас уже есть какой-либо автозагрузчик классов, включающий стандарт [PSR-0][0], вам нужно просто
        зарегистрировать в нем новое пространство имен Kupivkredit:

        `$someLoader->register('Kupivkredit', 'path/to/src');`

    *   Автоматическая загрузка классов с использованием загрузчика КупиВкредит.
        Если вы установили Библиотеку без использования composer, и в вашем приложении отсутсвует загрузчки, включающие
        стандарт [PSR-0][0], вы можете воспользоваться загрузчиком КупиВкредит, являющимся частью Библиотеки:

        `
        require_once('path/to/src/Kupivkredit/ClassLoader/ClassLoader.php');
        $classLoader = new \Kupivkredit\ClassLoader\ClassLoader();
        $classLoader->registerAutoload();
        `
    *   "Ручное" подключение классов с использованием операторов include/require.

Хранение параметров
--------------------------------

Являетесь ли вы партнером КупиВкредит, или только тестируете интеграцию - в любом случае вам понадобиться использовать
параметры партнера. Простейший вариант хранения - просто определить их в переменных:

```php
$partnerId = '1-17YB8ON';
$apiKey    = '123qwe';
$apiSecret = '321ewq';
$host      = Kupivkredit::HOST_TEST;
```

Формирование запроса
--------------------------------

После того, как вы настроили загрузку классов и импортировали класс Кupivkredit, можно отправить первый запрос на сервер.
В данном случае это будет простой вызов **ping**.

В соответствии с документацией КупиВкредит, сообщение вызова **ping** выглядит следующим образом:

```xml
<?xml version="1.0" encoding="utf-8" ?>
<request>
    <partnerId>...</partnerId>
    <apiKey>...</apiKey>
</request>
```

Далее, это сообщение подписывается и присылается в конверте:

```xml
<?xml version="1.0" encoding="utf-8" ?>
<envelope>
    <Base64EncodedMessage>...</Base64EncodedMessage>
    <RequestSignature>...</RequestSignature>
</envelope>
```

Сформировать сообщение и завернуть его в конверт с помощью Библиотеки можно следующим образом:

```php
/* @var $builder \Kupivkredit\EnvelopeBuilder\IEnvelopeBuilder */
$builder = $kupivkredit->get('envelope-builder');
$envelope = $builder->build(
    array(
        'partnerId' => $partnerId,
        'apiKey'    => $apiKey
    ),
    $apiSecret
);
```

Далее, полученный объект нужно просто отправить на соответствующий вызову маршрут:

```php
/* @var $caller \Kupivkredit\Caller\ICaller */
$caller  = $kupivkredit->get('caller');
$response = $caller->call($host.'/'.Kupivkredit::API_PING, $envelope->asXML());
```


[0]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md
[1]: http://www.php.net/manual/ru/language.namespaces.rationale.php
[2]: http://php.net/manual/ru/language.namespaces.importing.php