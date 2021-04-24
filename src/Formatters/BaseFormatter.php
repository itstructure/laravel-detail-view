<?php

namespace Itstructure\DetailView\Formatters;

use Itstructure\DetailView\Interfaces\Formatable;
use Itstructure\DetailView\Traits\{Configurable, Attributable};

/**
 * Class BaseFormatter
 * @package Itstructure\DetailView\Formatters
 */
abstract class BaseFormatter implements Formatable
{
    use Configurable, Attributable;

    /**
     * BaseFormatter constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->loadConfig($config);
    }
}
