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

namespace Kupivkredit\EnvelopeBuilder;

use Kupivkredit\XML\IConstructorXML;
use Kupivkredit\Envelope;
use Kupivkredit\Sign\ISignService;

/**
 * Имплементация билдера конверта API-вызова.
 *
 * @package EnvelopeBuilder
 * @author Sergey Kamardin <s.kamardin@tcsbank.ru>
 */
class EnvelopeBuilderImpl implements IEnvelopeBuilder
{
	/**
	 * Сервис подписи сообщения.
	 *
	 * @var ISignService
	 */
	protected $signService    = null;

	/**
	 * Конструктор XML.
	 *
	 * @var IConstructorXML
	 */
	protected $constructorXML = null;


	/**
	 * Создает конверт API-вызова.
	 *
	 * @param array $message
	 * @param string $apiSecret
	 * @return Envelope
	 */
	public function build(array $message, $apiSecret)
	{
		$request = $this->constructorXML->makeXML('request', $message);

		$base64  = base64_encode($request->asXML());
		$sign    = $this->signService->sign($base64, $apiSecret);

		$envelope = new Envelope(sprintf('<%1$s></%1$s>', Envelope::TAG));
		$envelope->addChild(Envelope::MESSAGE, $base64);
		$envelope->addChild(Envelope::SIGN, $sign);

		return $envelope;
	}

	/**
	 * Устанавливает конструктор XML.
	 *
	 * @param IConstructorXML $constructorXML
	 */
	public function setConstructorXML(IConstructorXML $constructorXML)
	{
		$this->constructorXML = $constructorXML;
	}

	/**
	 * Устанавливает сервис подписи сообщений.
	 *
	 * @param ISignService $signService
	 */
	public function setSignService(ISignService $signService)
	{
		$this->signService = $signService;
	}
}
