<?php

namespace Itstructure\DetailView\Rows;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CallbackRow.
 * @package Itstructure\DetailView\Rows
 */
class CallbackRow extends BaseRow
{
    /**
     * @param Model $model
     * @return mixed
     */
    public function getValue(Model $model)
    {
        return call_user_func($this->value, $model) ?? '';
    }
}
