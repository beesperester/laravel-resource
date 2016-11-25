<?php

namespace tests;

use Illuminate\Http\Request;

use Beesperester\Resource\Controllers\ResourceApiController;
use Beesperester\Resource\Models\ResourceModelInterface;

// models
use tests\TestModel;

class TestApiController extends ResourceApiController
{
    public $instance_name = 'tests\TestModel';
    public $instance_parameter = 'testmodel';
}
