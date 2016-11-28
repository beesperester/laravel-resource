<?php

namespace Beesperester\Resource\Models;

use Illuminate\Database\Eloquent\Model;

class ResourceModel extends Model implements ResourceModelInterface
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
    * Get validation rules.
    *
    * @param ResourceModelInterface $instance
    * @return array
    */
    public static function getValidationRules(ResourceModelInterface $instance = Null, Array $data = []) {
        return [];
    }
}
