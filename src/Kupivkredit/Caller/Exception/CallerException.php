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

namespace Kupivkredit\Caller\Exception;

use Kupivkredit\Exception\KupivkreditException;

/**
 * Исключение пакета.
 *
 * @package Caller
 * @author Sergey Kamardin <s.kamardin@tcsbank.ru>
 */
class CallerException extends KupivkreditException
{
	/**
	 * Тело ответа запроса.
	 *
	 * @var string
	 */
	protected $body;

	/**
	 * Конструктор
	 *
	 * @param string $message
	 * @param int $body
	 */
	public function __construct($message = "", $body)
	{
		parent::__construct($message);

		$this->body    = $body;
	}

	/**
	 * Возвращает тело ответа запроса.
	 *
	 * @return string
	 */
	public function getBody()
	{
		return $this->body;
	}
}
