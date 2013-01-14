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

use SimpleXMLElement;
use Kupivkredit\Exception\KupivkreditException;

/**
 * Ответ по API-вызову.
 * Расширяет класс SimpleXMLElement.
 *
 * @see \SimpleXMLElement
 *
 * @package Kupivkredit
 * @author Sergey Kamardin <s.kamardin@tcsbank.ru>
 */
class Response extends SimpleXMLElement
{
	const LANGUAGE_RUS   = 'rus';
	const LANGUAGE_ENG   = 'eng';

	const STATUS_FAILED  = 'FAILED';
	const STATUS_SUCCESS = 'OK';


	/**
	 * Возвращает сообщение ответа по языку.
	 *
	 * @param $language
	 * @return string
	 * @throws KupivkreditException
	 */
	public function getMessage($language)
	{
		if (isset($this->messages->{$language})) {
			return (string) $this->messages->{$language};
		} else {
			throw new KupivkreditException("Trying to get undefined message");
		}
	}

	/**
	 * Возвращает результат ответа.
	 *
	 * @return SimpleXMLElement
	 */
	public function getResult()
	{
		/* @var $result \Kupivkredit\Response */
		$result = $this->result;

		return new SimpleXMLElement($result->asXML());
	}

	/**
	 * Возвращает статус ответа.
	 *
	 * @return string
	 */
	public function getStatus()
	{
		return (string) $this->status;
	}

	/**
	 * Возвращает код статуса ответа.
	 *
	 * @return string
	 */
	public function getStatusCode()
	{
		return (string) $this->statusCode;
	}

	/**
	 * Возвращает признак успешного выполнения запроса.
	 *
	 * @return bool
	 */
	public function isSucceed()
	{
		return $this->getStatus() == self::STATUS_SUCCESS;
	}
}
