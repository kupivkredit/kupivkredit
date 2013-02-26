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

Инициализация
--------------------------------

Инициализация Библиотеки в виде модуля вашего веб-приложения осуществляется через инстанцирование базового класса Kupivkredit:

```php
$kupivkredit = new Kupivkredit();
```

> Вы можете отказаться от исользования Библиотеки в виде модуля и использовать только необходимые вам классы Библиотеки через
> простое инстанцирование нужного класса в соответствии с его интерфейсом.

Являетесь ли вы партнером КупиВкредит, или только тестируете интеграцию - в любом случае вам понадобиться использовать
параметры партнера. Простейший вариант хранения - просто передать их при инициализации объекта Kupivkredit:

```php
$kupivkredit = new Kupivkredit(
    array(
        'partnerId' => '1-17YB8ON',
        'apiKey'    => '123qwe',
        'apiSecret' => '321ewq',
        'host'      => Kupivkredit::HOST_TEST,
    )
);
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

Быстрый способ отправки запроса (рекомендуется)
--------------------------------

Существует короткий и удобный способ вызывать метод API - это **Kupivkredit::call()**.

Данный метод принимает три параметра, два из которых опциональны:

   + $method : string - Имя вызова (хранится в константах класса Kupivkredit, например Kupivkredit::API_PING)
   + [$message : array = array()] - Сообщение, тег params из документации API
   + [$options : array = array()] - Набор параметров в формате [curl_setopt_array][3]

В случае с вызовом Ping нам достаточно передать лишь первый параметр:

```php
$result = $kupivkredit->call(Kupivkredit::API_PING);
```

> В случае, если вы используете прокси сервер, и нуждаетесь в дополнительных настройках http вызова - вам следует передать третий параметр $options.


Дробный способ отправки запроса
--------------------------------

Сформировать сообщение и завернуть его в конверт можно так же чуть более сложным, но гибким способом:

```php
/* @var $enveloper \Kupivkredit\EnvelopeBuilder\IEnvelopeBuilder */
/* @var $requester \Kupivkredit\RequestBuilder\IRequestBuilder */
/* @var $caller \Kupivkredit\Caller\ICaller */
$requester = $kupivkredit->get('request-builder');
$enveloper = $kupivkredit->get('envelope-builder');
$caller    = $kupivkredit->get('caller');

$request = $requester->build(
	array(
		'partnerId' => '1-17YB8ON',
		'apiKey'    => '123qwe',
		'params'    => array()
	)
);

$envelope = $enveloper->build($request, '321ewq');

$result = $caller->call(Kupivkredit::HOST_TEST.'/'.Kupivkredit::API_PING, $envelope->asXML());

// Вывод результата API-вызова:
print_r($response);
```

Структура сообщений
--------------------------------

Ниже представлены структуры сообщений для существующих API-вызовов.

**В случае использования быстрого способа отправки запроса, сообщением будет содержание поля 'params'**

> Ключи представленных ниже массивов неизменны, ваши данные передаются только в значениях.

### ping

```php
$request = array(
    'partnerId' => '1-17YB8ON',
    'apiKey'    => '123qwe',
    'params'    => array(),
);
```

### get_decision

```php
$request = array(
    'partnerId' => '1-17YB8ON',
    'apiKey'    => '123qwe',
    'params'    => array(
        'PartnerOrderId' => 'your_order_id_here'
    ),
);
```

### change_order

```php
$request = array(
    'partnerId' => '1-17YB8ON',
    'apiKey'    => '123qwe',
    'params'    => array(
        'PartnerOrderId' => 'your_order_id_here',
        'Products' => array(
            'Product' => array(
                array(
                    'ProductName'     => 'Your Product First',
                    'ProductPrice'    => 12000,
                    'ProductQuantity' => 1,
                    'Category'        => 'Category'
                ),
                array(
                    'ProductName'     => 'Your Product Second',
                    'ProductPrice'    => 15000,
                    'ProductQuantity' => 1,
                    'Category'        => 'Category'
                ),
            ),
        ),
        'DesiredMonthlyPayment' => 1000,
        'DesiredCreditPeriod'   => 12,
        'DesiredAmount'         => 12000,
    ),
);
```

### confirm_order

```php
$request = array(
    'partnerId' => '1-17YB8ON',
    'apiKey'    => '123qwe',
    'params'    => array(
        'PartnerOrderId' => 'your_order_id_here',
        'SigningType'    => 'partner',
    ),
);
```

### get_contract

```php
$request = array(
    'partnerId' => '1-17YB8ON',
    'apiKey'    => '123qwe',
    'params'    => array(
        'PartnerOrderId' => 'your_order_id_here',
    ),
);
```

### order_completed

```php
$request = array(
    'partnerId' => '1-17YB8ON',
    'apiKey'    => '123qwe',
    'params'    => array(
        'PartnerOrderId' => 'your_order_id_here',
    ),
);
```

### cancel_order

```php
$request = array(
    'partnerId' => '1-17YB8ON',
    'apiKey'    => '123qwe',
    'params'    => array(
        'PartnerOrderId' => 'your_order_id_here',
        'Reason'         => 'Reason',
    ),
);
```

### get_takeover_documents

```php
$request = array(
    'partnerId' => '1-17YB8ON',
    'apiKey'    => '123qwe',
    'params'    => array(
        'PartnerOrderIds' => array(
            'id' => array(
                'your_order_id_here',
                'your_another_order_id_here',
                'your_another_another_order_id_here'
            )
        )
    ),
);
```

### get_return_goods_form

```php
$request = array(
    'partnerId' => '1-17YB8ON',
    'apiKey'    => '123qwe',
    'params'    => array(
        'PartnerOrderId'         => 'your_order_id_here',
        'ReturnedAmount'         => 1000,
        'CashReturnedToCustomer' => 100
    ),
);
```




[0]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md
[1]: http://www.php.net/manual/ru/language.namespaces.rationale.php
[2]: http://php.net/manual/ru/language.namespaces.importing.php
[3]: http://www.php.net/manual/ru/function.curl-setopt-array.php