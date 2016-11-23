<?php

namespace Beesperester\Resource\Models;

interface ResourceModelInterface
{
    /**
    * Get validation rules.
    *
    * @var Client $client
    * @return array
    */
    public static function getValidationRules(ResourceModelInterface $instance = NULL, Array $data = []);
}
