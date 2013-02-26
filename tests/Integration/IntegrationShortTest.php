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

use Kupivkredit\Kupivkredit;
use Kupivkredit\Caller\ICaller;
use Kupivkredit\Response;

/**
 * Интеграционный тест вызовов API.
 * Проверяет корректность структур данных, а так же сопоставляет ожидаемый ответ с фактическим.
 *
 * @package Integration
 * @author Sergey Kamardin <s.kamardin@tcsbank.ru>
 */
class IntegrationShortTest extends AbstractIntegrationTest
{
	/**
	 * Провайдер данных вызовов.
	 *
	 * @return array
	 */
	public function dataProvider()
	{
		return include __DIR__.DIRECTORY_SEPARATOR.'provider.php';
	}

	/**
	 * Тест ручного формирования вызовов.
	 *
	 * @param array $message
	 * @param array $params
	 * @param array $expected
	 *
	 * @dataProvider dataProvider
	 */
	public function testCall(array $message, array $params, array $expected)
	{
		/** @var $kupivkredit \Kupivkredit\Kupivkredit */
		$kupivkredit = new Kupivkredit(array(
			'partnerId' => $message['partnerId'],
			'apiKey'    => $message['apiKey'],
			'apiSecret' => $params['apiSecret'],
			'host'      => Kupivkredit::HOST_TEST,
		));

		/** @var $callProvider \Kupivkredit\CallProvider\ICallProvider */
		$callProvider = $kupivkredit->get('call-provider');

		$result = $callProvider->call($params['method'], $message['params'], array(CURLOPT_PROXY => null));

		$this->assertInstanceOf('Kupivkredit\Response', $result);
		$this->assertEquals($expected['status'], $result->getStatus());

		if (!is_null($expected['code'])) {
			$this->assertEquals($expected['code'], $result->getStatusCode());
		}
	}
}
