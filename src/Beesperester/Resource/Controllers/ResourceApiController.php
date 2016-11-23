<?php

namespace Beesperester\Resource\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Beesperester\Resource\Models\ResourceModelInterface;

use Exception;

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
    * Show all instances.
    *
    * @var Request $request
    * @return array
    */
    public function index(Request $request) {
        return call_user_func($this->instance_name . '::all');
    }

    /**
    * Create new Instance.
    *
    * @var Request $request
    * @return Instance
    */
    public function create(Request $request) {

    }

    /**
    * Create new Instance of Api.
    *
    * @return ApiController
    */
    public static function createAdapter() {
        return new static(True);
    }

    /**
    * Store new Instance.
    *
    * @var Request $request
    * @return Instance
    */
    public function store(Request $request) {
        $rules = $this->getValidationRules(NULL, $request->all());

        $this->validate($request, $rules);

        $instance = $this->storeInstance($request->all());

        $this->updateInstanceConnections($request, $instance);

        return $instance;
    }

    /**
    * Show Instance.
    *
    * @var Request $request
    * @return Instance
    */
    public function show(Request $request) {
        return $this->getInstance($request->{$this->instance_parameter});
    }

    /**
    * Edit Instance.
    *
    * @var Request $request
    * @return Instance
    */
    public function edit(Request $request) {

    }

    /**
    * Update Instance.
    *
    * @var Request $request
    * @return Instance
    */
    public function update(Request $request) {
        $instance = $this->getInstance($request->{$this->instance_parameter});

        $rules = $this->getValidationRules($instance);

        $this->validate($request, $rules);

        $instance = $this->updateInstance($instance, $request->all());

        $this->updateInstanceConnections($request, $instance);

        return $instance;
    }

    /**
    * Destroy Instance.
    *
    * @var Request $request
    * @return array
    */
    public function destroy(Request $request) {
        $instance = $this->getInstance($request->{$this->instance_parameter});

        return $this->destroyInstance($instance);
    }

    /**
    * Prepare Data for insertion.
    *
    * @var Array $data
    * @return Array
    */
    public function prepareData(Array $data = []) {
        return $data;
    }

    /**
    * Get the actual Instance.
    *
    * @var array $data
    * @return Instance
    */
    public function getInstance($id) {
        return call_user_func($this->instance_name . '::findOrFail', $id);
    }

    /**
    * Get validation rules from Model.
    *
    * @var ResourceModelInterface $instance
    * @var Array $data
    * @return Array
    */
    public function getValidationRules(ResourceModelInterface $instance = NULL, Array $data = []) {
         return call_user_func($this->instance_name . '::getValidationRules', $instance, $data);
    }

    /**
    * Create the actual Instance.
    *
    * @var array $data
    * @return Instance
    */
    public function storeInstance(Array $data = []) {
        $data = $this->prepareData($data);

        return call_user_func($this->instance_name . '::create', $data);
    }

    /**
    * Create the actual Instance after validation.
    *
    * @var array $data
    * @return Instance
    */
    public function storeInstanceWithValidation(Array $data = []) {
        $rules = $this->getValidationRules(NULL, $data);

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new Exception('Store validation error');
        }

        return $this->storeInstance($data);
    }

    /**
    * Update the actual Instance.
    *
    * @var Instance $instance
    * @var array $data
    * @return Instance
    */
    public function updateInstance(ResourceModelInterface $instance, Array $data = []) {
        $data = $this->prepareData($data);

        $instance->update($data);

        return $instance;
    }

    /**
    * Update Instance Connections.
    *
    * @var Request $request
    * @var ResourceModelInterface $instance
    */
    public function updateInstanceConnections(Request $request, ResourceModelInterface $instance) {

        $relations = $instance->relations;

        if (array_key_exists('belongsToMany', $relations)) {
            // update belongsToMany relations
            foreach ($relations['belongsToMany'] as $related_instance_name => $relation_config) {
                // update relations
                $input_name = $relation_config['parameter'] . '_ids';

                if ($request->has($input_name)) {
                    $input_data = $request->{$input_name};

                    #echo $relation_config['attribute'];
                    #echo '<pre>';print_r($input_data);echo '</pre>';

                    // remove babes not present in babe_ids
                    foreach ($instance->{$relation_config['attribute']} as $related_instance) {

                        if (!in_array($related_instance->id, $input_data)) {
                            #echo 'detach ' . $related_instance->id . '<br/>';
                            $instance->{$relation_config['attribute']}()->detach($related_instance);
                        }
                    }

                    // add new related instance
                    foreach ($input_data as $related_instance_id) {
                        $related_instance = call_user_func($related_instance_name . '::find', $related_instance_id);

                        if ($related_instance && !$instance->{$relation_config['attribute']}->contains($related_instance)) {
                            $instance->{$relation_config['attribute']}()->attach($related_instance);
                        }
                    }
                }
            }
        }
    }

    /**
    * Update the actual Instance with validation.
    *
    * @var Instance $instance
    * @var array $data
    * @return Instance
    */
    public function updateInstanceWithValidation(ResourceModelInterface $instance, Array $data = []) {
        $rules = $this->getValidationRules($instance, $data);

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new Exception('Update validation error');
        }

        return $this->updateInstance($instance, $data);
    }

    /**
    * Destroy the actual Instance.
    *
    * @var Instance $instance
    * @return Instance
    */
    public function destroyInstance(ResourceModelInterface $instance) {
        $instance_data = $instance->toArray();

        $instance->delete();

        return $instance_data;
    }
}
