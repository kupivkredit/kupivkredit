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
    'properties' => array(),
    'constructor-xml' => array(
        'class' => 'Kupivkredit\XMLBuilder\XMLBuilder'
    ),
    'caller' => array(
        'class' => 'Kupivkredit\Caller\CallerHTTP',
    ),
    'sign-service' => array(
        'class' => 'Kupivkredit\SignService\SignService',
    ),
    'envelope-builder' => array(
        'class' => 'Kupivkredit\EnvelopeBuilder\EnvelopeBuilder',
	    'arguments' => array(
		    '@sign-service'
	    )
    ),
	'request-builder' => array(
		'class' => 'Kupivkredit\RequestBuilder\RequestBuilder',
		'calls' => array(
			'setXMLBuilder' => array('@constructor-xml')
		)
	),
	'call-provider' => array(
		'class' => 'Kupivkredit\CallProvider\CallProvider',
		'arguments' => array(
			'@request-builder',
			'@envelope-builder',
			'@caller',
			'%partnerId%',
			'%apiKey%',
			'%apiSecret%',
			'%host%',
		)
	)
);
