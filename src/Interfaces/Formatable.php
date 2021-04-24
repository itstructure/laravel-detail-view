<?php

namespace Itstructure\DetailView\Interfaces;

/**
 * Interface Formatable
 * @package Itstructure\DetailView\Interfaces
 */
interface Formatable
{
    /**
     * @param $value
     * @return mixed
     */
    public function format($value);
}
