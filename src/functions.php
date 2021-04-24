<?php
/**
 * @param array $config
 * @return string
 */
function detail_view(array $config)
{
    return (new \Itstructure\DetailView\Detail($config))->render();
}
