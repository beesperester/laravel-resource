<?php

namespace tests;

use Illuminate\Http\Request;

use Beesperester\Resource\Controllers\ResourceViewController;

// models
use App\TestModel;

class TestViewController extends ResourceViewController
{
    /**
    * Construct
    */
    public function __construct() {
        $this->api = TestApiController::createAdapter();
    }
}
