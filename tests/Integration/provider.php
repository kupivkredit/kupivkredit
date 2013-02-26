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

use Kupivkredit\Kupivkredit;
use Kupivkredit\Response;

/**
 * Провайдер данных для интеграционных тестов в формате PHPUnit.
 *
 * @package Integration
 * @author Sergey Kamardin <s.kamardin@tcsbank.ru>
 */
return array(
	// #0 API_PING Ok
	array(
		array(
			'partnerId' => '1-17YB8ON',
			'apiKey' => '123qwe',
			'params' => array()
		),
		array(
			'host'      => Kupivkredit::HOST_TEST,
			'method'    => Kupivkredit::API_PING,
			'apiSecret' => '321ewq',
		),
		array(
			'status'=> Response::STATUS_SUCCESS,
			'code' => null
		)
	),

	// #1 API_PING Invalid authentication
	array(
		array(
			'partnerId' => uniqid(),
			'apiKey' => '123qwe',
			'params' => array()
		),
		array(
			'host'      => Kupivkredit::HOST_TEST,
			'method'    => Kupivkredit::API_PING,
			'apiSecret' => '321ewq',
		),
		array(
			'status'=> Response::STATUS_FAILED,
			'code' => self::INVALID_AUTHENTICATION
		)
	),

	// #3 API_GET_DECISION The order "xxx" not found
	array(
		array(
			'partnerId' => '1-17YB8ON',
			'apiKey' => '123qwe',
			'params' => array(
				'PartnerOrderId' => uniqid('test'),
			)
		),
		array(
			'host'      => Kupivkredit::HOST_TEST,
			'method'    => Kupivkredit::API_GET_DECISION,
			'apiSecret' => '321ewq',
		),
		array(
			'status'=> Response::STATUS_FAILED,
			'code' => self::ORDER_NOT_FOUND
		)
	),

	// #4 API_CHANGE_ORDER The order "xxx" not found
	array(
		array(
			'partnerId' => '1-17YB8ON',
			'apiKey' => '123qwe',
			'params' => array(
				'PartnerOrderId' => uniqid('test'),
				'Products' => array(
					'Product' => array(
						array(
							'ProductName'     => 'Test',
							'ProductPrice'    => 12000,
							'ProductQuantity' => 1,
							'Category'        => 'Test'
						),
						array(
							'ProductName'     => 'Test2',
							'ProductPrice'    => 15000,
							'ProductQuantity' => 1,
							'Category'        => 'Test2'
						),
					),
				),
				'DesiredMonthlyPayment' => 1000,
				'DesiredCreditPeriod' => 12,
				'DesiredAmount' => 12000,
			)
		),
		array(
			'host'      => Kupivkredit::HOST_TEST,
			'method'    => Kupivkredit::API_CHANGE_ORDER,
			'apiSecret' => '321ewq',
		),
		array(
			'status'=> Response::STATUS_FAILED,
			'code' => self::ORDER_NOT_FOUND
		)
	),

	// #5 API_CONFIRM_ORDER The order "xxx" not found
	array(
		array(
			'partnerId' => '1-17YB8ON',
			'apiKey' => '123qwe',
			'params' => array(
				'PartnerOrderId' => uniqid('test'),
				'SigningType'    => 'partner'
			)
		),
		array(
			'host'      => Kupivkredit::HOST_TEST,
			'method'    => Kupivkredit::API_CONFIRM_ORDER,
			'apiSecret' => '321ewq',
		),
		array(
			'status'=> Response::STATUS_FAILED,
			'code' => self::ORDER_NOT_FOUND
		)
	),

	// #6 API_GET_CONTRACT The order "xxx" not found
	array(
		array(
			'partnerId' => '1-17YB8ON',
			'apiKey' => '123qwe',
			'params' => array(
				'PartnerOrderId' => uniqid('test')
			)
		),
		array(
			'host'      => Kupivkredit::HOST_TEST,
			'method'    => Kupivkredit::API_GET_CONTRACT,
			'apiSecret' => '321ewq',
		),
		array(
			'status'=> Response::STATUS_FAILED,
			'code' => self::ORDER_NOT_FOUND
		)
	),

	// #7 API_ORDER_COMPLETED The order "xxx" not found
	array(
		array(
			'partnerId' => '1-17YB8ON',
			'apiKey' => '123qwe',
			'params' => array(
				'PartnerOrderId' => uniqid('test')
			)
		),
		array(
			'host'      => Kupivkredit::HOST_TEST,
			'method'    => Kupivkredit::API_ORDER_COMPLETED,
			'apiSecret' => '321ewq',
		),
		array(
			'status'=> Response::STATUS_FAILED,
			'code' => self::ORDER_NOT_FOUND
		)
	),

	// #8 API_CANCEL_ORDER The order "xxx" not found
	array(
		array(
			'partnerId' => '1-17YB8ON',
			'apiKey' => '123qwe',
			'params' => array(
				'PartnerOrderId' => uniqid('test'),
				'Reason' => 'Test'
			)
		),
		array(
			'host'      => Kupivkredit::HOST_TEST,
			'method'    => Kupivkredit::API_CANCEL_ORDER,
			'apiSecret' => '321ewq',
		),
		array(
			'status'=> Response::STATUS_FAILED,
			'code' => self::ORDER_NOT_FOUND
		)
	),

	// #9 API_GET_TAKEOVER_DOCUMENTS The order "xxx" not found
	array(
		array(
			'partnerId' => '1-17YB8ON',
			'apiKey' => '123qwe',
			'params' => array(
				'PartnerOrderIds' => array(
					'id' => array(
						uniqid('test'),
						uniqid('test'),
						uniqid('test')
					)
				)
			)
		),
		array(
			'host'      => Kupivkredit::HOST_TEST,
			'method'    => Kupivkredit::API_GET_TAKEOVER_DOCUMENTS,
			'apiSecret' => '321ewq',
		),
		array(
			'status'=> Response::STATUS_SUCCESS,
			'code' => null
		)
	),

	// #10 API_GET_RETURN_GOODS_FORM The order "xxx" not found
	array(
		array(
			'partnerId' => '1-17YB8ON',
			'apiKey' => '123qwe',
			'params' => array(
				'PartnerOrderId'         => uniqid('test'),
				'ReturnedAmount'         => 1000,
				'CashReturnedToCustomer' => 100
			)
		),
		array(
			'method'    => Kupivkredit::API_GET_RETURN_GOODS_FORM,
			'host'      => Kupivkredit::HOST_TEST,
			'apiSecret' => '321ewq',
		),
		array(
			'status'=> Response::STATUS_FAILED,
			'code' => 1010
		)
	),

);