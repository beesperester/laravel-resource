<?php

namespace Beesperester\Resource\Controllers;

use Illuminate\Http\Request;

class ResourceViewController extends LaravelController implements ResourceControllerInterface
{
    /**
    * Construct
    */
    public function __construct() {
        $this->api = ResourceApiController::createAdapter();
    }

    /**
    * Create new Instance.
    *
    * @param Request $request
    * @return Instance
    */
    public function create(Request $request) {
        return view($this->getInstanceView('create'));
    }

    /**
    * Destroy Instance.
    *
    * @param Request $request
    * @return array
    */
    public function destroy(Request $request) {
        $instance = $this->api->destroy($request);

        return redirect($this->api->instance_parameter);
    }

    /**
    * Edit Instance.
    *
    * @param Request $request
    * @return Instance
    */
    public function edit(Request $request) {
        $instance = $this->api->edit($request);

        $view_data = [];

        $view_data[$this->api->instance_parameter] = $instance;

        return view($this->getInstanceView('edit'), $view_data);
    }

    /**
    * Get pluralized name.
    *
    * @return string
    */
    public function getInstancesName() {
        return str_plural($this->api->instance_parameter);
    }

    /**
    * Get controller instance view name.
    *
    * @return array
    */
    public function getInstanceView($template = '') {
        return implode('/', [$this->api->instance_parameter, $template]);
    }

    /**
    * Show all instances.
    *
    * @param Request $request
    * @return array
    */
    public function index(Request $request) {
        $instances = $this->api->index($request);

        $view_data = [];

        $view_data[$this->getInstancesName()] = $instances;

        return view($this->getInstanceView('index'), $view_data);
    }

    /**
    * Show Instance.
    *
    * @param Request $request
    * @return Instance
    */
    public function show(Request $request) {
        $instance = $this->api->show($request);

        $view_data = [];

        $view_data[$this->api->instance_parameter] = $instance;

        return view($this->getInstanceView('show'), $view_data);
    }

    /**
    * Store new Instance.
    *
    * @param Request $request
    * @return Instance
    */
    public function store(Request $request) {
        $instance = $this->api->store($request);
        $redirect = '';

        if ($instance) {
            $redirect = '/' . $instance->id;
        }

        return redirect($this->api->instance_parameter . $redirect);
    }

    /**
    * Update Instance.
    *
    * @param Request $request
    * @return Instance
    */
    public function update(Request $request) {
        $instance = $this->api->update($request);

        return redirect($this->api->instance_parameter . '/' . $instance->id);
    }
}
