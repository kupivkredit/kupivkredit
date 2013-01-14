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

namespace Kupivkredit\Sign;

/**
 * Имплементация сервиса подписи сообщения.
 *
 * @package Sign
 * @author Sergey Kamardin <s.kamardin@tcsbank.ru>
 */
class SignServiceImpl implements ISignService
{
	/**
	 * Количество итераций алгоритма по умолчанию.
	 *
	 * @var int
	 */
	public $iterationCount;

	/**
	 * Подписывает сообщение.
	 *
	 * @param string $message
	 * @param string $secret
	 * @param int|null $iterationCount
	 * @return string
	 */
	public function sign($message, $secret, $iterationCount = null) {
		if (is_null($iterationCount)) {
			$iterationCount = $this->iterationCount;
		}

		$message = $message.$secret;
		$result = md5($message).sha1($message);

		for($i = 0; $i < $iterationCount; $i++) {
			$result = md5($result);
		}

		return $result;
	}
}
