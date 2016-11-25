<?php

namespace Beesperester\Resource\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Beesperester\Resource\Models\ResourceModelInterface;
use Beesperester\Resource\Exceptions\MissingInstanceException;
use Beesperester\Resource\Exceptions\ValidateInstanceException;
use Beesperester\Resource\Exceptions\MissingKeyException;

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
    * Create new ResourceModelInterface.
    *
    * @var Request $request
    * @return ResourceModelInterface
    */
    public function create(Request $request) {

    }

    /**
    * Create new ResourceModelInterface of Api.
    *
    * @return ApiController
    */
    public static function createAdapter() {
        return new static(True);
    }

    /**
    * Destroy ResourceModelInterface.
    *
    * @var Request $request
    * @return array
    */
    public function destroy(Request $request) {
        return $this->destroyFromRequest($request);
    }

    /**
    * Destroy ResourceModelInterface from Request.
    *
    * @var Request $request
    * @return array
    */
    public function destroyFromRequest(Request $request) {
        $instance = $this->getInstance($request->{$this->instance_parameter});

        return $this->destroyInstance($instance);
    }

    /**
    * Destroy ResourceModelInterface from Array.
    *
    * @var Array $array
    * @return array
    */
    public function destroyFromData(Array $data = []) {
        if (!isset($data['id'])) {
            throw new MissingKeyException('Missing id key in data');
        }

        $instance = $this->getInstance($data['id']);

        return $this->destroyInstance($instance);
    }

    /**
    * Destroy the actual ResourceModelInterface.
    *
    * @var ResourceModelInterface $instance
    * @return ResourceModelInterface
    */
    public function destroyInstance(ResourceModelInterface $instance) {
        $instance_data = $instance->toArray();

        $instance->delete();

        return $instance_data;
    }

    /**
    * Edit ResourceModelInterface.
    *
    * @var Request $request
    * @return ResourceModelInterface
    */
    public function edit(Request $request) {

    }

    /**
    * Get the actual ResourceModelInterface.
    *
    * @var array $data
    * @return ResourceModelInterface
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
    public function getValidationRules(ResourceModelInterface $instance = Null, Array $data = []) {
         return call_user_func($this->instance_name . '::getValidationRules', $instance, $data);
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
    * Prepare Data for insertion.
    *
    * @var Array $data
    * @return Array
    */
    public function prepareData(Array $data = []) {
        return $data;
    }

    /**
    * Store new ResourceModelInterface.
    *
    * @var Request $request
    * @return ResourceModelInterface
    */
    public function store(Request $request) {
        return $this->storeFromRequest($request);
    }

    /**
    * Store new ResourceModelInterface from Request.
    *
    * @var Request $request
    * @return ResourceModelInterface
    */
    public function storeFromRequest(Request $request) {
        $rules = $this->getValidationRules(Null, $request->all());

        $this->validate($request, $rules);

        $instance = $this->storeInstance($request->all());

        try {
            $this->updateInstanceConnectionsFromRequest($request, $instance);
        } catch (MissingInstanceException $e) {

        } catch (Exception $e) {

        }

        return $instance;
    }

    /**
    * Store new ResourceModelInterface from Array.
    *
    * @var Array $data
    * @return ResourceModelInterface
    */
    public function storeFromData(Array $data = [], $update_connections = False) {
        $rules = $this->getValidationRules(Null, $data);

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidateInstanceException('Unable to to store instance: ' . implode(', ', $validator->errors()->toArray()));
        }

        $instance = $this->storeInstance($data);

        if ($update_connections) {
            try {
                $this->updateInstanceConnectionsFromData($data, $instance);
            } catch (MissingInstanceException $e) {

            } catch (Exception $e) {

            }
        }

        return $instance;
    }

    /**
    * Create the actual ResourceModelInterface.
    *
    * @var array $data
    * @return ResourceModelInterface
    */
    public function storeInstance(Array $data = []) {
        $data = $this->prepareData($data);

        return call_user_func($this->instance_name . '::create', $data);
    }

    /**
    * Show ResourceModelInterface.
    *
    * @var Request $request
    * @return ResourceModelInterface
    */
    public function show(Request $request) {
        return $this->getInstance($request->{$this->instance_parameter});
    }

    /**
    * Update ResourceModelInterface.
    *
    * @var Request $request
    * @return ResourceModelInterface
    */
    public function update(Request $request) {
        return $this->updateFromRequest($request);
    }

    /**
    * Update ResourceModelInterface from Request.
    *
    * @var Request $request
    * @return ResourceModelInterface
    */
    public function updateFromRequest(Request $request) {
        $instance = $this->getInstance($request->{$this->instance_parameter});

        $rules = $this->getValidationRules($instance);

        $this->validate($request, $rules);

        $instance = $this->updateInstance($instance, $request->all());

        try {
            $this->updateInstanceConnectionsFromRequest($request, $instance);
        } catch (MissingInstanceException $e) {

        } catch (Exception $e) {

        }

        return $instance;
    }

    /**
    * Update ResourceModelInterface from Array.
    *
    * @var ResourceModelInterface $instance
    * @var Array $data
    * @return ResourceModelInterface
    */
    public function updateFromData(ResourceModelInterface $instance, Array $data = [], $update_connections = False) {
        $rules = $this->getValidationRules($instance, $data);

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidateInstanceException('Unable to to update instance: ' . implode(', ', $validator->errors()->toArray()));
        }

        $instance = $this->updateInstance($instance, $data);

        if ($update_connections) {
            try {
                $this->updateInstanceConnectionsFromData($data, $instance);
            } catch (MissingInstanceException $e) {

            } catch (Exception $e) {

            }
        }

        return $instance;
    }

    /**
    * Update the actual ResourceModelInterface.
    *
    * @var ResourceModelInterface $instance
    * @var array $data
    * @return ResourceModelInterface
    */
    public function updateInstance(ResourceModelInterface $instance, Array $data = []) {
        $data = $this->prepareData($data);

        $instance->update($data);

        return $instance;
    }

    /**
    * Update ResourceModelInterface Connections from Request.
    *
    * @var Request $request
    * @var ResourceModelInterface $instance
    */
    public function updateInstanceConnectionsFromRequest(Request $request, ResourceModelInterface $instance = Null) {
        return $this->updateInstanceConnectionsFromData($request->all(), $instance);
    }

    /**
    * Update ResourceModelInterface Connections from Array.
    *
    * @var Array $data
    * @var ResourceModelInterface $instance
    */
    public function updateInstanceConnectionsFromData(Array $data = [], ResourceModelInterface $instance = Null) {

        if (!$instance) {
            throw new MissingInstanceException('Missing instance');
        }

        $relations = $instance->relations;

        if (array_key_exists('belongsToMany', $relations)) {
            // update belongsToMany relations
            foreach ($relations['belongsToMany'] as $related_instance_name => $relation_config) {
                // update relations
                $relation_attribute = $relation_config['attribute'];

                if (array_key_exists($relation_attribute, $data)) {
                    $input_data = $data[$relation_attribute];

                    #echo $relation_config['attribute'];
                    #echo '<pre>';print_r($input_data);echo '</pre>';

                    // remove relations not present in attribute
                    foreach ($instance->{$relation_attribute} as $related_instance) {

                        if (!in_array($related_instance->id, $input_data)) {
                            #echo 'detach ' . $related_instance->id . '<br/>';
                            $instance->{$relation_attribute}()->detach($related_instance);
                        }
                    }

                    // add new related instance
                    foreach ($input_data as $related_instance_data) {
                        if (array_key_exists('id', $related_instance_data)) {
                            $id = $related_instance_data['id'];

                            $related_instance = call_user_func($related_instance_name . '::find', $id);

                            if ($related_instance && !$instance->{$relation_attribute}->contains($related_instance)) {
                                $instance->{$relation_attribute}()->attach($related_instance);
                            }
                        }
                    }
                }
            }
        }
    }
}
