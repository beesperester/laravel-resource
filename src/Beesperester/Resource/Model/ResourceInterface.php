<?php

namespace Beesperester\Resource\Model;

interface ResourceModelInterface
{
    /**
    * Get validation rules.
    *
    * @var Client $client
    * @return array
    */
    public static function getValidationRules(ResourceInterface $instance = NULL, Array $data = []);
}
