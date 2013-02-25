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

namespace Kupivkredit\EnvelopeBuilder;

use Kupivkredit\XMLBuilder\IXMLBuilder;
use Kupivkredit\Request;
use Kupivkredit\Envelope;
use Kupivkredit\SignService\ISignService;

/**
 * Имплементация билдера конверта API-вызова.
 *
 * @package EnvelopeBuilder
 * @author Sergey Kamardin <s.kamardin@tcsbank.ru>
 */
class EnvelopeBuilder implements IEnvelopeBuilder
{

	/**
	 * Создает конверт API-вызова.
	 *
	 * @param  Request               $request
	 * @param  string                $sign
	 *
	 * @return \Kupivkredit\Envelope
	 */
	public function build(Request $request, $sign)
    {
        $envelope = new Envelope(sprintf('<%1$s></%1$s>', Envelope::TAG));

        $envelope->addChild(Envelope::MESSAGE, $request->toString());
        $envelope->addChild(Envelope::SIGN,    $sign);

        return $envelope;
    }
}
