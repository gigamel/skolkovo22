<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once dirname(__DIR__) . '/autoload.php';

(new \Magazine())->run();
