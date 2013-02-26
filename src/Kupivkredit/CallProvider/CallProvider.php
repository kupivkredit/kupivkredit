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

namespace Kupivkredit\CallProvider;

use Kupivkredit\CallProvider\ICallProvider;
use Kupivkredit\Caller\ICaller;
use Kupivkredit\EnvelopeBuilder\IEnvelopeBuilder;
use Kupivkredit\SignService\ISignService;
use Kupivkredit\RequestBuilder\IRequestBuilder;

/**
 * Провайдер сервиса вызова методов API.
 *
 * @package CallProvider
 * @author Sergey Kamardin <s.kamardin@tcsbank.ru>
 */
class CallProvider implements ICallProvider
{
	/**
	 * @var IRequestBuilder
	 */
	protected $requester;

	/**
	 * @var ISignService
	 */
	protected $signer;

	/**
	 * @var IEnvelopeBuilder
	 */
	protected $enveloper;

	/**
	 * @var ICaller
	 */
	protected $caller;

	/**
	 * @var string
	 */
	protected $partnerId;

	/**
	 * @var string
	 */
	protected $apiKey;

	/**
	 * @var string
	 */
	protected $apiSecret;

	/**
	 * @var string
	 */
	protected $host;

	/**
	 * Конструктор.
	 *
	 * @param IRequestBuilder  $requester
	 * @param IEnvelopeBuilder $enveloper
	 * @param ICaller          $caller
	 * @param string           $partnerId
	 * @param string           $apiKey
	 * @param string           $apiSecret
	 * @param string           $host
	 */
	public function __construct(IRequestBuilder $requester, IEnvelopeBuilder $enveloper, ICaller $caller, $partnerId, $apiKey, $apiSecret, $host)
	{
		$this->requester = $requester;
		$this->enveloper = $enveloper;
		$this->caller    = $caller;
		$this->partnerId = $partnerId;
		$this->apiKey    = $apiKey;
		$this->apiSecret = $apiSecret;
		$this->host      = $host;
	}

	/**
	 * Формирует конверт сообщения и передает его указанному методу API.
	 *
	 * @param string $method
	 * @param array  $message
	 * @param array  $options
	 *
	 * @return bool|\Kupivkredit\Response
	 */
	public function call($method, array $message = array(), array $options = array())
	{
		$message = array(
			'partnerId' => $this->partnerId,
			'apiKey'    => $this->apiKey,
			'params'    => $message
		);

		$request  = $this->requester->build($message);
		$envelope = $this->enveloper->build($request, $this->apiSecret);

		return $this->caller->call(implode('/', array($this->host, $method)), $envelope->asXML(), $options);
	}
}
