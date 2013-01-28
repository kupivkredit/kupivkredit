<?php
/**
 * Этот файл является частью библиотеки КупиВкредит.
 *
 * Все права защищены (c) 2012 «Тинькофф Кредитные Системы» Банк (закрытое акционерное общество)
 *
 * Информация о типе распространения данного ПО указана в файле LICENSE,
 * распространяемого вместе с исходным кодом библиотеки.
 *
 * This file is part of the KupiVkredit library.
 *
 * Copyright (c) 2012  «Tinkoff Credit Systems» Bank (closed joint-stock company)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Пример получения данных по кредитной заявке.
 *
 * @author Sergey Kamardin <s.kamardin@tcsbank.ru>
 */

use Kupivkredit\Kupivkredit;

// Инициализация загрузчика классов:

require_once(dirname(__DIR__) . '/src/Kupivkredit/ClassLoader/ClassLoader.php');
$classLoader = new \Kupivkredit\ClassLoader\ClassLoader();
$classLoader->registerAutoload();

// Инициализация контейнера сервисов КупиВкредит:

$kupivkredit = new Kupivkredit();

// Инициализация параметров партнера КупиВкредит:

$partnerId = '1-17YB8ON';
$apiKey    = '123qwe';
$apiSecret = '321ewq';
$host      = implode('/', array(Kupivkredit::HOST_TEST, Kupivkredit::API_GET_TAKEOVER_DOCUMENTS));

/**
 * Получение необходимых сервисов для отправки запроса:
 *
 * @var $builder \Kupivkredit\EnvelopeBuilder\IEnvelopeBuilder
 * @var $caller \Kupivkredit\Caller\ICaller
 */
$builder = $kupivkredit->get('envelope-builder');
$caller  = $kupivkredit->get('caller');

// Формирование сообщения API-вызова:

$envelope = $builder->build(
    array(
        'partnerId' => $partnerId,
        'apiKey'    => $apiKey,
	    'params'    => array(
		    'PartnerOrderIds' => array(
			    'id' => array(
				    'your_order_id_here',
				    'your_another_order_id_here',
				    'your_another_another_order_id_here'
			    )
		    )
	    )
    ),
    $apiSecret
);

// Отправка сообщения, получение результата API-вызова:

$response = $caller->call($host, $envelope->asXML());

// Вывод результата API-вызова:

print_r($response);
