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

/**
 * Загрузчик классов.
 *
 * @package Kupivkredit
 * @author Sergey Kamardin <s.kamardin@tcsbank.ru>
 */
class ClassLoader
{
	/**
	 * Корень директории Kupivkredit.
	 *
	 * @var string
	 */
	protected $root = '';

	/**
	 * Список зарегистрированных namespace'ов.
	 *
	 * @var array
	 */
	protected $namespaces = array();

	/**
	 * Конструктор.
	 */
	public function __construct ()
	{
		$this->register('Kupivkredit', dirname(__DIR__).DIRECTORY_SEPARATOR);
	}

	/**
	 * Регистрирует namespace и путь к его корневой папке.
	 *
	 * @param $name
	 * @param $path
	 */
	public function register($name, $path)
	{
		$this->namespaces[$name] = $path;
	}

	/**
	 * Загружает класс.
	 *
	 * @param $class
	 * @return bool
	 */
	public function loadClass($class)
	{
		if ($file = $this->findFile($class)) {
			require $file;
		}
	}

	/**
	 * Выполняет поиск файла класса.
	 *
	 * @param string $class
	 * @return string
	 */
	public function findFile ($class)
	{
		$core      = substr($class, 0, strpos($class, '\\')) ?: '';
		$namespace = substr($class, 0, strrpos($class, '\\')) ?: '';
		$className = substr($class, strrpos($class, '\\') + 1) ?: '';

		if (array_key_exists($core, $this->namespaces)) {
			$file = $this->namespaces[$core].str_replace('\\', '/', $namespace).'/'.$className.'.php';
			if (is_file($file)) {
				return $file;
			}
		}

		return false;
	}

	/**
	 * Регистрирует загрузчик в списке загрузчиков классов.
	 *
	 * @see spl_autoload_register
	 *
	 * @param bool $prepend
	 * @return ClassLoader
	 */
	public function registerAutoload($prepend = false)
	{
		spl_autoload_register(array($this, 'loadClass'), true, $prepend);

		return $this;
	}

	/**
	 * Удаляет загрузчик из списка загрузчиков классов.
	 *
	 * @see spl_autoload_unregister
	 *
	 * @return ClassLoader
	 */
	public function unregisterAutoload ()
	{
		spl_autoload_unregister(array($this, 'loadClass'));

		return $this;
	}
}

