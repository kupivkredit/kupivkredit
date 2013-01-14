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
 * Конфигурация зависимостей
 *
 * @var array
 * @author Sergey Kamardin <s.kamardin@tcsbank.ru>
 */
$_config = array(
	'properties' => array(
		'iterationCount' => 1102,
	),
	'constructor-xml' => array(
		'class' => 'Kupivkredit\XML\ConstructorXML'
	),
	'caller' => array(
		'class' => 'Kupivkredit\Caller\CallerHTTP',
	),
	'sign-service' => array(
		'class' => 'Kupivkredit\Sign\SignServiceImpl',
		'properties' => array(
			'iterationCount' => '%iterationCount%'
		)
	),
	'envelope-builder' => array(
		'class' => 'Kupivkredit\EnvelopeBuilder\EnvelopeBuilderImpl',
		'calls' => array(
			'setSignService'    => array('@sign-service'),
			'setConstructorXML' => array('@constructor-xml'),
		),
	)
);
