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
class IntegrationTest extends AbstractIntegrationTest
{
	const MALFORMED_XML          = 1080;
	const ORDER_NOT_FOUND        = 1010;
	const INVALID_AUTHENTICATION = 4040;

	/**
	 * @var \Kupivkredit\Kupivkredit
	 */
	protected $kupivkredit;

	/**
	 * @var \Kupivkredit\RequestBuilder\IRequestBuilder;
	 */
	protected $requester;

	/**
	 * @var \Kupivkredit\SignService\ISignService;
	 */
	protected $signer;

	/**
	 * @var \Kupivkredit\EnvelopeBuilder\IEnvelopeBuilder;
	 */
	protected $enveloper;

	/**
	 * @var \Kupivkredit\Caller\ICaller;
	 */
	protected $caller;

	/**
	 * Настройки перед каждым тестом.
	 */
	public function setUp()
	{
		$this->kupivkredit = new Kupivkredit();

		$this->requester = $this->kupivkredit->get('request-builder');
		$this->signer    = $this->kupivkredit->get('sign-service');
		$this->enveloper = $this->kupivkredit->get('envelope-builder');
		$this->caller    = $this->kupivkredit->get('caller');
	}

	/**
	 * Провайдер данных вызовов.
	 *
	 * @return array
	 */
	public function callProvider()
	{
		$default = include __DIR__.DIRECTORY_SEPARATOR.'provider.php';

		$uniq = array(
			// #2 API_PING Malformed XML
			array(
				array(
					'partnerId' => '1-17YB8ON',
					'params' => array()
				),
				array(
					'host'      => Kupivkredit::HOST_TEST,
					'method'    => Kupivkredit::API_PING,
					'apiSecret' => '321ewq',
				),
				array(
					'status'=> Response::STATUS_FAILED,
					'code' => null
				)
			),
		);

		return array_merge($default, $uniq);
	}

	/**
	 * Тест ручного формирования вызовов.
	 *
	 * @param array $message
	 * @param array $params
	 * @param array $expected
	 *
	 * @dataProvider callProvider
	 */
	public function testCall(array $message, array $params, array $expected)
	{
		$request  = $this->requester->build($message);
		$envelope = $this->enveloper->build($request, $params['apiSecret']);

		$result = $this->caller->call(
			implode('/', array($params['host'], $params['method'])),
			$envelope->asXML(),
			array(CURLOPT_PROXY => null)
		);

		$this->assertInstanceOf('Kupivkredit\Response', $result);
		$this->assertEquals($expected['status'], $result->getStatus());

		if (!is_null($expected['code'])) {
			$this->assertEquals($expected['code'], $result->getStatusCode());
		}
	}
}
