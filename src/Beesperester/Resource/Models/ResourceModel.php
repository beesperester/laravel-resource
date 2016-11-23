<?php

namespace Beesperester\Resource\Models;

use Illuminate\Database\Eloquent\Model;

class ResourceModel extends Model implements ResourceModelInterface
{
    /**
    * Get validation rules.
    *
    * @var ResourceModelInterface $instance
    * @return array
    */
    public static function getValidationRules(ResourceModelInterface $instance = NULL, Array $data = []) {
        return [];
    }
}
