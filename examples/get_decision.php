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

$kupivkredit = new Kupivkredit(array(
	'partnerId' => '1-17YB8ON',
	'apiKey'    => '123qwe',
	'apiSecret' => '321ewq',
	'host'      => Kupivkredit::HOST_TEST,
));

// Отправка сообщения, получение результата API-вызова (короткий, рекомендованный способ):

$result = $kupivkredit->call(Kupivkredit::API_GET_DECISION, array('PartnerOrderId' => 'your_order_id_here'), array(CURLOPT_PROXY => null));

// Вывод результата API-вызова:
print_r($result);

// Отправка сообщения, получение результата API-вызова (доробный способ):

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

$result = $caller->call(Kupivkredit::HOST_TEST.'/'.Kupivkredit::API_GET_DECISION, $envelope->asXML(), array(CURLOPT_PROXY => null));

// Вывод результата API-вызова:
print_r($result);