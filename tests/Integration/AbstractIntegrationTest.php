<?php
/**
 *
 * @package
 * @author Sergey Kamardin <s.kamardin@tcsbank.ru>
 */
abstract class AbstractIntegrationTest extends PHPUnit_Framework_TestCase
{
	const MALFORMED_XML          = 1080;
	const ORDER_NOT_FOUND        = 1010;
	const INVALID_AUTHENTICATION = 4040;
}
