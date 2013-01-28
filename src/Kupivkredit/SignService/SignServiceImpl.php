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

namespace Kupivkredit\SignService;

/**
 * Имплементация сервиса подписи сообщения.
 *
 * @package SignService
 * @author Sergey Kamardin <s.kamardin@tcsbank.ru>
 */
class SignServiceImpl implements ISignService
{
    const ITERATION_COUNT = 1102;

    /**
     * Подписывает сообщение.
     *
     * @param  string $message
     * @param  string $secret
     * @return string
     */
    public function sign($message, $secret)
    {
        $message = $message.$secret;
        $result = md5($message).sha1($message);

        for ($i = 0; $i < self::ITERATION_COUNT; $i++) {
            $result = md5($result);
        }

        return $result;
    }
}
