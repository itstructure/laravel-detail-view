<?php

namespace Itstructure\DetailView\Heads;

use Itstructure\DetailView\Traits\{Configurable, Attributable};

/**
 * Class ColumnHead
 * @package Itstructure\DetailView\Heads
 */
class ColumnHead
{
    use Configurable, Attributable;

    /**
     * @var string
     */
    protected $label;

    /**
     * ColumnHead constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->loadConfig($config);
    }

    /**
     * Get label for detail head.
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label ?? '';
    }
}
