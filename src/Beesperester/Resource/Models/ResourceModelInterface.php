<?php

namespace Beesperester\Resource\Models;

interface ResourceModelInterface
{
    /**
    * Get validation rules.
    *
    * @param Client $client
    * @return array
    */
    public static function getValidationRules(ResourceModelInterface $instance = Null, Array $data = []);
}
