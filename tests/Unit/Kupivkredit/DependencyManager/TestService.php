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
 * Класс тестового сервиса, позволяющий тестировать работу DependencyManager'а
 *
 * @package DependencyManager
 * @author Sergey Kamardin <s.kamardin@tcsbank.ru>
 */
class TestService
{
	/**
	 * Публичное свойство
	 * @var string|null
	 */
	public $property = null;

	/**
	 * Закрытое свойство
	 * @var string|null
	 */
	protected $argument = null;

	/**
	 * Приватное свойство
	 * @var string|null
	 */
	private $call = null;

	/**
	 * Конструктор.
	 *
	 * @param string $argument
	 */
	public function __construct($argument)
	{
		$this->argument = $argument;
	}

	/**
	 * Сеттер свойства.
	 *
	 * @param string $call
	 */
	public function setCall($call)
	{
		$this->call = $call;
	}

	/**
	 * Геттер свойства, установленного через сеттер.
	 *
	 * @return null|string
	 */
	public function getCall()
	{
		return $this->call;
	}

	/**
	 * Геттер свойства, установленного через конструктор.
	 *
	 * @return null|string
	 */
	public function getArgument()
	{
		return $this->argument;
	}
}
