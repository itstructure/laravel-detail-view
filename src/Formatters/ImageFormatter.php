<?php

namespace Itstructure\DetailView\Formatters;

/**
 * Class ImageFormatter.
 * @package Itstructure\DetailView\Formatters
 */
class ImageFormatter extends BaseFormatter
{
    /**
     * Format value as image.
     * @param $value
     * @return mixed|string
     */
    public function format($value)
    {
        return '<img src="' . $value . '" ' . $this->buildHtmlAttributes() . ' />';
    }
}
