<?php

namespace Itstructure\DetailView\Formatters;

/**
 * Class UrlFormatter
 * @package Itstructure\DetailView\Formatters
 */
class UrlFormatter extends BaseFormatter
{
    /**
     * @var string
     */
    protected $title = '';

    /**
     * Format value as url.
     * @param $value
     * @return mixed|string
     */
    public function format($value)
    {
        return '<a href="' . $value . '" ' . $this->buildHtmlAttributes() . ' >' . !empty($this->title) ? $this->title : $value . '</a>';
    }
}
