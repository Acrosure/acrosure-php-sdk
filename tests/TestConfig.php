<?php

define('TOKEN', 'tokn_sample_public');
define('ENDPOINT_BASE', 'https://api.phantompage.com');

require_once dirname(__FILE__).'/../lib/Acrosure.php';

abstract class TestConfig extends PHPUnit_Framework_TestCase { }
