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

namespace Kupivkredit\Caller;

use Kupivkredit\Envelope;

/**
 * Интерфейс отправителя API-вызова.
 *
 * @package Caller
 * @author Sergey Kamardin <s.kamardin@tcsbank.ru>
 */
interface ICaller
{
	const HOST_TEST        = 'https://kupivkredit-test-api.tcsbank.ru:8100/api';
	const HOST_PRODUCTION  = 'https://api.kupivkredit.ru/api';

	const API_PING                   = 'ping';
	const API_GET_DECISION           = 'get_decision';
	const API_CHANGE_ORDER           = 'change_order';
	const API_CONFIRM_ORDER          = 'confirm_order';
	const API_GET_CONTRACT           = 'get_contract';
	const API_ORDER_COMPLETED        = 'order_completed';
	const API_CANCEL_ORDER           = 'cancel_order';
	const API_GET_TAKEOVER_DOCUMENTS = 'get_takeover_documents';
	const API_GET_RETURN_GOODS_FORM  = 'get_return_goods_form';

	/**
	 * Отправляет запрос.
	 *
	 * @param $host
	 * @param $call
	 * @param Envelope $envelope
	 * @return \Kupivkredit\Response
	 */
	public function call($host, $call, Envelope $envelope);
}
