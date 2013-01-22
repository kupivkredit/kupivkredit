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

namespace Kupivkredit\XMLBuilder;

use SimpleXMLElement;

/**
 * Имплементация конструктора XML.
 *
 * @package XML
 * @author Sergey Kamardin <s.kamardin@tcsbank.ru>
 */
class XMLBuilder implements IXMLBuilder
{
	/**
	 * Преобразует полученный массив в xml с заданным заглавным тегом.
	 *
	 * @param string $tag
	 * @param array $data
	 * @return \SimpleXMLElement
	 */
	public function makeXML($tag, array $data)
	{
		$node = new SimpleXMLElement(sprintf('<%1$s></%1$s>', $tag));

		return $this->constructXML($node, $data);
	}

	/**
	 * Рекурсивно заполняет xml-объект.
	 *
	 * @param SimpleXMLElement $node
	 * @param array $data
	 * @return SimpleXMLElement
	 */
	protected function constructXML(SimpleXMLElement $node, array $data)
	{
		foreach($data as $k => $v) {
			if (is_array($v)) {
				$keys = array_keys($v);
				$allNumeric = true;

				foreach($keys as $kk) {
					$allNumeric = $allNumeric && is_numeric($kk);
				}

				if ($allNumeric) {
					foreach($keys as $nKey) {
						if (is_array($v[$nKey])) {
							$this->constructXML($node->addChild($k), $v[$nKey]);
						} else {
							$node->{$k}[$nKey] = $v[$nKey];
						}
					}
				} else {
					$this->constructXML($node->addChild($k), $v);
				}
			} else {
				$node->$k = $v;
			}
		}

		return $node;
	}
}
