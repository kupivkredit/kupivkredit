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

namespace Kupivkredit\Caller;

use Kupivkredit\Response;

/**
 * Имплементация отправителя API-вызовов.
 * Использует расширение php curl для отправки запроса по протоколу HTTP(S).
 *
 * @see curl_init(), curl_setopt_array(), curl_exec()
 * @link http://ru.wikipedia.org/wiki/HTTP
 *
 * @package Caller
 * @author Sergey Kamardin <s.kamardin@tcsbank.ru>
 */
class CallerHTTP implements ICaller
{
    /**
     * Отправляет запрос.
     *
     * @param string $host
     * @param string $data
     *
     * @return Response
     */
    public function call($host, $data = '')
    {
        $curl = curl_init();

        $options = array(
            CURLOPT_URL            => $host,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => $data,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => true,
        );

        curl_setopt_array($curl, $options);

        $curlExec = curl_exec($curl);

        if ($curlExec !== false) {
            $body = substr($curlExec, curl_getinfo($curl, CURLINFO_HEADER_SIZE));
            $response = new Response($body);
        } else {
            $response =  false;
        }

        curl_close($curl);

        return $response;
    }
}
