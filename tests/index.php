<?php

error_reporting( E_ALL );
ini_set('display_errors', 1);

require __DIR__ . '/../vendor/autoload.php';

use Beesperester\Resource\Controllers\ResourceApiController;

class ApiController extends ResourceApiController
{

}

$api = ApiController::createAdapter();

echo 'foo';
