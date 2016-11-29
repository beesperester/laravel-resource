<?php

namespace Beesperester\Resource\Controllers;

use Illuminate\Http\Request;

class ResourceApiController extends LaravelController implements ResourceControllerInterface
{
    public $instance_name = '';
    public $instance_parameter = '';

    /**
    * Construct
    */
    public function __construct($is_adapter = False) {

    }

    /**
    * Create new ResourceModel.
    *
    * @param Request $request
    * @return ResourceModel
    */
    public function create(Request $request) {

    }

    /**
    * Create new ResourceModel of Api.
    *
    * @return ApiController
    */
    public static function createAdapter() {
        return new static(True);
    }

    /**
    * Destroy ResourceModel.
    *
    * @param Request $request
    * @return array
    */
    public function destroy(Request $request) {
        $instance = $this->getInstance($request->{$this->instance_parameter});

        $instance_data = $instance->toArray();

        $instance->delete();

        return $instance_data;
    }

    /**
    * Edit ResourceModel.
    *
    * @param Request $request
    * @return ResourceModel
    */
    public function edit(Request $request) {
        return $this->getInstance($request->{$this->instance_parameter});
    }

    /**
    * Get the actual ResourceModel.
    *
    * @param array $data
    * @return ResourceModel
    */
    public function getInstance($id) {
        return call_user_func($this->instance_name . '::findOrFail', $id);
    }

    /**
    * Show all instances.
    *
    * @param Request $request
    * @return array
    */
    public function index(Request $request) {
        return call_user_func($this->instance_name . '::all');
    }

    /**
    * Store new ResourceModel.
    *
    * @param Request $request
    * @return ResourceModel
    */
    public function store(Request $request) {
        $rules = call_user_func($this->instance_name . '::getValidationRules', Null, $request->all());

        $this->validate($request, $rules);

        $instance = call_user_func($this->instance_name . '::create', $request->all());

        $instance->updateConnections($request->all());

        return $instance;
    }

    /**
    * Show ResourceModel.
    *
    * @param Request $request
    * @return ResourceModel
    */
    public function show(Request $request) {
        return $this->getInstance($request->{$this->instance_parameter});
    }

    /**
    * Update ResourceModel.
    *
    * @param Request $request
    * @return ResourceModel
    */
    public function update(Request $request) {
        $instance = $this->getInstance($request->{$this->instance_parameter});

        $rules = call_user_func($this->instance_name . '::getValidationRules', $instance, $request->all());

        $this->validate($request, $rules);

        $instance->update($request->all());
        $instance->updateConnections($request->all());

        return $instance;
    }
}
