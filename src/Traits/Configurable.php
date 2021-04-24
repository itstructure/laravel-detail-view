<?php

namespace Itstructure\DetailView\Traits;

use ReflectionClass;

/**
 * Class Configurable
 * @package Itstructure\DetailView\Traits
 */
trait Configurable
{
    /**
     * @param array $config
     */
    public function loadConfig(array $config = [])
    {
        $attributes = $this->attributes();

        foreach ($config as $key => $value) {
            if (!in_array($key, $attributes)) {
                continue;
            }
            $this->{$key} = $value;
        }
    }

    /**
     * @return array
     */
    protected function attributes()
    {
        $class = new ReflectionClass($this);
        $names = [];
        foreach ($class->getProperties() as $property) {
            if (!$property->isStatic()) {
                $names[] = $property->getName();
            }
        }

        return $names;
    }
}
