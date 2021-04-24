<?php

namespace Itstructure\DetailView\Rows;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Itstructure\DetailView\Formatters\{HtmlFormatter, ImageFormatter, TextFormatter, UrlFormatter};
use Itstructure\DetailView\Interfaces\Formatable;
use Itstructure\DetailView\Traits\{Configurable, Attributable};

/**
 * Class BaseRow
 * @package Itstructure\DetailView\Rows
 */
abstract class BaseRow
{
    use Configurable, Attributable;

    const
        FORMATTER_HTML = 'html',
        FORMATTER_IMAGE = 'image',
        FORMATTER_TEXT = 'text',
        FORMATTER_URL = 'url',

        FORMATTER_DEFINITIONS = [
            self::FORMATTER_HTML => HtmlFormatter::class,
            self::FORMATTER_IMAGE => ImageFormatter::class,
            self::FORMATTER_TEXT => TextFormatter::class,
            self::FORMATTER_URL => UrlFormatter::class,
        ];

    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $attribute;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var string|Formatable
     */
    protected $format;

    /**
     * BaseRow constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->loadConfig($config);
        $this->buildFormatter();
    }

    /**
     * @param Model $model
     * @return mixed
     */
    abstract public function getValue(Model $model);

    /**
     * Render row attribute value.
     * @param $model
     * @return mixed
     */
    public function render($model)
    {
        return $this->formatTo($this->getValue($model));
    }

    /**
     * Format value with formatter.
     * @param $value
     * @return mixed
     */
    public function formatTo($value)
    {
        return $this->format->format($value);
    }

    /**
     * Get title for detail head.
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label ?? ucfirst($this->attribute);
    }

    /**
     * Get attribute.
     * @return string|null
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @param Formatable $formatter
     */
    protected function setFormatter(Formatable $formatter): void
    {
        $this->format = $formatter;
    }

    /**
     * @throws Exception
     * @return void
     */
    protected function buildFormatter(): void
    {
        if (is_null($this->format)) {
            $class = self::FORMATTER_DEFINITIONS[self::FORMATTER_TEXT];
            $this->format = new $class;

        } else if (is_string($this->format)) {
            $class = self::FORMATTER_DEFINITIONS[$this->format] ?? self::FORMATTER_DEFINITIONS[self::FORMATTER_TEXT];
            $this->format = new $class;

        } else if (is_array($this->format)) {
            if (isset($this->format['class']) && class_exists($this->format['class'])) {
                $this->setFormatter(new $this->format['class']($this->format));
            }

        } else if (!is_object($this->format) || !($this->format instanceof Formatable)) {
            throw new Exception('Incorrect formatter.');
        }
    }
}
