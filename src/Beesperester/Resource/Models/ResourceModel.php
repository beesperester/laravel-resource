<?php

namespace Beesperester\Resource\Models;

use Beesperester\Resource\Exceptions\ValidationException;

// laravel
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Validator;

class ResourceModel extends Model
{
    /**
    * An array describing the instance relations.
    *
    * @param array
    */
    public $relations = [
        //
    ];

    /**
    * Override create to include data preparation.
    *
    * @param Array $data
    * @return this
    */
    public static function create(Array $data = []) {
        $data = static::prepareData($data);

        return parent::create($data);
    }

    /**
    * Find or create.
    *
    * @param Relation $relation
    * @param Array $where
    * @param Array $data
    * @param Boolean $validate
    * @return Instance
    */
    public static function findOrCreate(Relation $relation = Null, Array $where = [], Array $data = [], $validate = True) {
        if ($relation) {
            $query = $relation->where($where);
        } else {
            $query = static::where($where);
        }

        $find = $query->first();

        if ($find) {
            return $find;
        } else {
            if ($validate) {
                static::validate($data);
            }

            return static::create($data);
        }
    }

    /**
    * Get validation rules.
    *
    * @param ResourceModel $instance
    * @return Array
    */
    public static function getValidationRules(ResourceModel $instance = Null, Array $data = []) {
        return [];
    }

    /**
    * Prepare data for database
    *
    * @param Array $data
    * @return Array
    */
    public static function prepareData(Array $data = []) {
        #inspect_array($data, True);

        return $data;
    }

    /**
    * Override update to include data preparation.
    *
    * @param Array $data
    * @return this
    */
    public function update(Array $data = [], Array $options = []) {
        $data = static::prepareData($data);

        return parent::update($data, $options);
    }

    /**
    * Update ResourceModel Connections from Array.
    *
    * @param Array $data
    * @return this
    */
    public function updateConnections(Array $data = []) {
        $instance = $this;
        $relations = $instance->relations;

        if (array_key_exists('belongsToMany', $relations)) {
            // update belongsToMany relations
            foreach ($relations['belongsToMany'] as $related_instance_name => $relation_config) {
                // update relations
                $relation_attribute = $relation_config['attribute'];

                if (array_key_exists($relation_attribute, $data)) {
                    $input_data = $data[$relation_attribute];

                    // remove relations not present in attribute
                    foreach ($instance->{$relation_attribute} as $related_instance) {

                        if (!in_array($related_instance->id, array_column($input_data, 'id'))) {
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

        return $this;
    }

    /**
    * Validate data
    *
    * @param ResourceModel $instance
    * @param Array $data
    * @return void
    */
    public static function validate(Array $data = [], ResourceModel $instance = Null) {
        $rules = static::getValidationRules($instance, $data);

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator, $validator->errors()->getMessages());
        }
    }
}
