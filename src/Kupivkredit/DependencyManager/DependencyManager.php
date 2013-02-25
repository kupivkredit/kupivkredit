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

namespace Kupivkredit\DependencyManager;

use ReflectionException;
use Kupivkredit\DependencyManager\Exception\DependencyManagerException;
use ReflectionClass;

/**
 * Имплементация менеджера зависимостей.
 *
 * @package DependencyManager
 * @author Sergey Kamardin <s.kamardin@tcsbank.ru>
 */
class DependencyManager implements IDependencyManager
{
    const PROPERTY_REGEXP = '/^%(.*)%$/i';
    const PROPERTY_VALUE  = '$1';
    const LINK_REGEXP     = '/^@(.*)$/i';
    const LINK_VALUE      = '$1';

    /**
     * Список уже инстанцированных сервисов.
     *
     * @var array
     */
    protected $services = array();

    /**
     * Конфигурация менеджера.
     *
     * @var array
     */
    protected $config = null;

    /**
     * Свойства конфигурации менеджера.
     *
     * @var array
     */
    protected $properties = null;

    /**
     * Устанавливает конфигурацию менеджера.
     *
     * @param  array                      $config
     * @throws DependencyManagerException
     */
    public function setConfig(array $config)
    {
        if (is_null($this->config) and is_null($this->properties)) {
            $this->config     = $config;
            $this->properties = isset($config['properties']) ? $config['properties'] : array();
        } else {
            throw new DependencyManagerException('DependencyManager already configured.');
        }
    }

    /**
     * Возвращает экземпляр сервиса по ключу.
     * В случае отсутствия конфигурации сервиса возубждает исключение.
     *
     * @param  string                     $service
     * @return object
     * @throws DependencyManagerException
     */
    public function get($service)
    {
        if (array_key_exists($service, $this->services)) {
            return $this->services[$service];
        }

        if (isset($this->config[$service])) {
            $this->services[$service] = $this->constructService($this->config[$service]);

            return $this->services[$service];
        } else {
            throw new DependencyManagerException("Service '$service' is not configured yet.");
        }
    }

    /**
     * Возвращает свойство конфигурации менеджера.
     * В случае отсутствия свойства возбуждает исключение.
     *
     * @param  string                     $name
     * @return mixed
     * @throws DependencyManagerException
     */
    public function getProperty($name)
    {
        if (is_array($this->properties) and array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        } else {
            throw new DependencyManagerException("Trying to get undefined property '$name'");
        }
    }

    /**
     * Инстанцирует класс сервиса.
     * В случае ошибки инстанцирования возбуждает исключение.
     *
     * @param  array                      $config
     * @return object
     * @throws DependencyManagerException
     */
    protected function constructService(array $config)
    {
        $arguments  = isset($config['arguments'])  ? $this->parseConfig($config['arguments'])  : array();
        $calls      = isset($config['calls'])      ? $this->parseConfig($config['calls'])      : array();
        $properties = isset($config['properties']) ? $this->parseConfig($config['properties']) : array();

        try {
            $reflection = new ReflectionClass($config['class']);
        } catch (ReflectionException $e) {
            throw new DependencyManagerException("Dependency manager could not construct service: {$e->getMessage()}");
        }

        $service = is_null($reflection->getConstructor())
            ? $reflection->newInstance()
            : $reflection->newInstanceArgs($arguments);

        array_walk(
            $calls,
            function ($args, $method) use ($service) {
                call_user_func_array(array($service, $method), $args);
            }
        );

        array_walk(
            $properties,
            function ($value, $key) use ($service) {
                $service->{$key} = $value;
            }
        );

        return $service;
    }

    /**
     * Рекурсивно обрабатывает конфигурацию.
     * В случае обнаружения ссылок на сервисы и свойства – заменяет их реальными значениями.
     * @todo Возможно сделать обычный foreach (можно будет скрыть метод getProperty)
     *
     * @param  array $arguments
     * @return array
     */
    public function parseConfig(array $arguments)
    {
        $me             = $this;
        $linkRegexp     = self::LINK_REGEXP;
        $linkValue      = self::LINK_VALUE;
        $propertyRegexp = self::PROPERTY_REGEXP;
        $propertyValue  = self::PROPERTY_VALUE;

        return array_map(
            function ($value) use ($me, $linkRegexp, $linkValue, $propertyRegexp, $propertyValue) {

                if (is_string($value)) {
                    if (preg_match($linkRegexp, $value)) {
                        return $me->get(preg_filter($linkRegexp, $linkValue, $value));
                    } elseif (preg_match($propertyRegexp, $value)) {
                        return $me->getProperty(preg_filter($propertyRegexp, $propertyValue, $value));
                    }

                    return $value;
                } elseif (is_array($value)) {
                    return $me->parseConfig($value);
                }

                return $value;
            },
            $arguments
        );
    }
}
