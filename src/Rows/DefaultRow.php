<?php

namespace Itstructure\DetailView\Rows;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DefaultRow
 * @package Itstructure\DetailView\Rows
 */
class DefaultRow extends BaseRow
{
    /**
     * @param Model $model
     * @return mixed
     */
    public function getValue(Model $model)
    {
        return $model->{$this->attribute} ?? '';
    }
}
