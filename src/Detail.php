<?php

namespace Itstructure\DetailView;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Itstructure\DetailView\Heads\ColumnHead;
use Itstructure\DetailView\Rows\{BaseRow, CallbackRow, DefaultRow};
use Itstructure\DetailView\Traits\{Configurable, Attributable};

/**
 * Class Detail
 * @package Itstructure\DetailView
 */
class Detail
{
    use Configurable, Attributable;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var array
     */
    protected $rowFields = [];

    /**
     * @var BaseRow[]
     */
    protected $rowObjects = [];

    /**
     * @var array
     */
    protected $captionColumnConfig = [];

    /**
     * @var array
     */
    protected $valueColumnConfig = [];

    /**
     * @var bool
     */
    protected $showHead = true;

    /**
     * Detail view constructor.
     * @param array $config
     * @throws Exception
     */
    public function __construct(array $config)
    {
        $this->loadConfig($config);
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $this->applyColumnsConfig();

        return view('detail_view::detail', [
            'detailObj' => $this,
            'model' => $this->model,
            'rowObjects' => $this->rowObjects,
            'title' => $this->title,
            'captionColumnHead' => $this->getCaptionColumnHead(),
            'valueColumnHead' => $this->getValueColumnHead(),
            'showHead' => $this->showHead
        ])->render();
    }

    protected function applyColumnsConfig(): void
    {
        foreach ($this->rowFields as $key => $config) {
            if (is_string($config)) {
                $this->fillRowObjects(new DefaultRow(['attribute' => $config]));
                continue;
            }

            if (is_array($config)) {
                if (isset($config['class']) && class_exists($config['class'])) {
                    $this->fillRowObjects(new $config['class']($config));
                    continue;
                }

                if (isset($config['value']) && $config['value'] instanceof Closure) {
                    $this->fillRowObjects(new CallbackRow($config));
                    continue;
                }

                $this->fillRowObjects(new DefaultRow($config));
            }
        }
    }

    /**
     * @param BaseRow $rowObject
     */
    protected function fillRowObjects(BaseRow $rowObject): void
    {
        $this->rowObjects = array_merge($this->rowObjects, [$rowObject]);
    }

    /**
     * @return ColumnHead
     */
    protected function getCaptionColumnHead(): ColumnHead
    {
        $config = array_merge([
            'label' => trans('detail_view::detail.title')
        ], $this->captionColumnConfig);

        return new ColumnHead($config);
    }

    /**
     * @return ColumnHead
     */
    protected function getValueColumnHead(): ColumnHead
    {
        $config = array_merge([
            'label' => trans('detail_view::detail.value')
        ], $this->valueColumnConfig);

        return new ColumnHead($config);
    }
}
