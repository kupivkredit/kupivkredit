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
	/**
	 * Конструктор.
	 *
	 * @param array $properties
	 */
	public function __construct(array $properties = array())
	{
		$config = call_user_func(function() {
			include('config.php');
			return $_config;
		});

		$config['properties'] = isset($config['properties']) ? array_merge($config['properties'], $properties) : $properties;

		$this->setConfig($config);
	}
}
