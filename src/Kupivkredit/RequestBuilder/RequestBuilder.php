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

use Kupivkredit\XMLBuilder\IXMLBuilder;
use Kupivkredit\Request;

class RequestBuilder implements IRequestBuilder
{
	/**
	 * Конструктор XML.
	 *
	 * @var IXMLBuilder
	 */
	protected $XMLBuilder = null;

	/**
	 * Создает сообщение API-вызова.
	 *
	 * @param  array                 $request
	 *
	 * @return \Kupivkredit\Request
	 */
	public function build(array $request)
	{
		$request = $this->XMLBuilder->makeXML(Request::TAG, $request);

		return new Request($request->asXML());
	}

	/**
	 * Устанавливает билдер XML.
	 *
	 * @param  IXMLBuilder $XMLBuilder
	 */
	public function setXMLBuilder(IXMLBuilder $XMLBuilder)
	{
		$this->XMLBuilder = $XMLBuilder;
	}
}
