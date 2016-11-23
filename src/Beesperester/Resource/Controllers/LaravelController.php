<?php

namespace Beesperester\Resource\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LaravelController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
