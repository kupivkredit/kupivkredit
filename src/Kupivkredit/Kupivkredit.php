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

namespace Kupivkredit;

use Kupivkredit\DependencyManager\DependencyManager;

/**
 * Расширяет базовый класс управления зависимостями.
 *
 * @package Kupivkredit
 * @author Sergey Kamardin <s.kamardin@tcsbank.ru>
 */
final class Kupivkredit extends DependencyManager
{
    const VERSION = '0.2.5';

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
     * Конструктор.
     *
     * @param array $properties
     */
    public function __construct(array $properties = array())
    {
        $config = call_user_func(
            function () {
                include 'config.php';
                return $_config;
            }
        );

        $config['properties'] =
            isset($config['properties']) ? array_merge($config['properties'], $properties) : $properties;

        $this->setConfig($config);
    }

	/**
	 * Ярлык на вызов метода в упрощенной форме.
	 *
	 * @param string $method
	 * @param array  $message
	 * @param array  $options
	 *
	 * @return bool|Response
	 */
	public function call($method, array $message = array(), array $options = array())
	{
		/** @var $callProvider \Kupivkredit\CallProvider\ICallProvider */
		$callProvider = $this->get('call-provider');

		return $callProvider->call($method, $message, $options);
	}
}
