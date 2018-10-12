<?php

define('TEST_SECRET_TOKEN', '<YOUR_SECRET>');
define('TEST_API_URL', 'https://api.phantompage.com');

require_once dirname(__FILE__).'/../lib/Acrosure.php';

abstract class TestConfig extends PHPUnit_Framework_TestCase {}
