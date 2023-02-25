# Laravel Detail View

[![Latest Stable Version](https://poser.pugx.org/itstructure/laravel-detail-view/v/stable)](https://packagist.org/packages/itstructure/laravel-detail-view)
[![Latest Unstable Version](https://poser.pugx.org/itstructure/laravel-detail-view/v/unstable)](https://packagist.org/packages/itstructure/laravel-detail-view)
[![License](https://poser.pugx.org/itstructure/laravel-detail-view/license)](https://packagist.org/packages/itstructure/laravel-detail-view)
[![Total Downloads](https://poser.pugx.org/itstructure/laravel-detail-view/downloads)](https://packagist.org/packages/itstructure/laravel-detail-view)
[![Build Status](https://scrutinizer-ci.com/g/itstructure/laravel-detail-view/badges/build.png?b=main)](https://scrutinizer-ci.com/g/itstructure/laravel-detail-view/build-status/main)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/itstructure/laravel-detail-view/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/itstructure/laravel-detail-view/?branch=main)

## Introduction

This package is to displaying the model data in a Detail table.

![Detail view appearance](https://github.com/itstructure/laravel-detail-view/blob/main/laravel_detail_view_appearance_en.png)

## Requirements
- laravel 5.5+ | 6+ | 7+ | 8+ | 9+ | 10+
- php >= 7.1
- composer

## Installation

### General from remote packagist repository

Run the composer command:

`composer require itstructure/laravel-detail-view "~1.0.4"`

### If you are testing this package from a local server directory

In application `composer.json` file set the repository, as in example:

```json
"repositories": [
    {
        "type": "path",
        "url": "../laravel-detail-view",
        "options": {
            "symlink": true
        }
    }
],
```

Here,

**../laravel-detail-view** - directory path, which has the same directory level as application and contains Detail View package.

Then run command:

`composer require itstructure/laravel-detail-view:dev-main --prefer-source`

### Registration

Register service provider in **config/app.php**

```php
Itstructure\DetailView\DetailViewServiceProvider::class,       
```

### Publish files (Not necessary)

- To publish views run command:

    `php artisan detail_view:publish --only=views`
    
    It stores view files to `resources/views/vendor/detail_view` folder.
    
- To publish translations run command:
                
    `php artisan detail_view:publish --only=lang`
    
    It stores translation files to `resources/lang/vendor/detail_view` folder.
    
- To publish all parts run command without `only` argument:

    `php artisan detail_view:publish`
    
    Else you can use `--force` argument to rewrite already published files.

Else you can use `--force` argument to rewrite already published file.

## Usage

### View template part

Use `@detailView()` directive with config array in a blade view template.

#### Simple quick usage

You can simply set rows to display as **string** format in `rowFields` array.

Note: `$model` must be instance of `Illuminate\Database\Eloquent\Model`.

```php
@php
$detailData = [
    'model' => $model,
    'title' => 'Detail table',
    'rowFields' => [
        'id',
        'active',
        'icon',
        'created_at'
    ]
];
@endphp
```

```php
@detailView($detailData)
```

Alternative variant without a blade directive:

```php
{!! detail_view([
    'model' => $model,
    'title' => 'Detail table',
    'rowFields' => [
        'id',
        'active',
        'icon',
        'created_at'
    ]
]) !!}
```

#### Setting custom options

##### Rows

Simple example:

```php
@detailView([
    'model' => $model,
    'rowFields' => [
        [
            'label' => 'First Name', // Row label.
            'attribute' => 'first_name', // Attribute, by which the row data will be taken from a model.
        ],
        [
            'label' => 'Last Name',
            'value' => function ($model) {
                return $model->last_name;
            }
        ],
    ]
])
```
    
##### Formatters

There are the next formatter keys:

- **html** - is for passing a row content with html tags.
- **image** - is for inserting a row data in to `src` attribute of `<img>` tag.
- **text** - applies `strip_tags()` for a row data.
- **url** - is for inserting a row data in to `href` attribute of `<a>` tag.

For that keys there are the next formatters:

- `HtmlFormatter`
- `ImageFormatter`
- `TextFormatter`
- `UrlFormatter`

Also you can set formatter with some addition options. See the next simple example:

```php
@detailView([
    'model' => $model,
    'rowFields' => [
        [
            'attribute' => 'url',
            'format' => [
                'class' => Itstructure\DetailView\Formatters\UrlFormatter::class,
                'title' => 'Source',
                'htmlAttributes' => [
                    'target' => '_blank'
                ]
            ]
        ],
        [
            'attribute' => 'content',
            'format' => 'html'
        ]
    ]
])
```

##### Table heads

To set column titles, you can set `captionColumnConfig` and `valueColumnConfig` as in example:

```php
@detailView([
    'model' => $model,
    'captionColumnConfig' => [
        'label' => 'Custom title column',
        'htmlAttributes' => [
            'class' => 'th-title-class'
        ]
    ],
    'valueColumnConfig' => [
        'label' => 'Custom value column',
        'htmlAttributes' => [
            'class' => 'th-value-class'
        ]
    ],
    'rowFields' => [
        [
            'attribute' => 'content',
        ]
    ]
])
```

To hide all table row with head titles:

```php
@detailView([
    'model' => $model,
    'showHead' => false,
    'rowFields' => [
        [
            'attribute' => 'content',
        ]
    ]
])
```

##### Complex extended example

```php
@php
$detailData = [
    'model' => $model,
    'title' => 'Detail title', // It can be empty ''
    'htmlAttributes' => [
        'class' => 'table table-bordered table-striped'
    ],
    'captionColumnConfig' => [
        'label' => 'Custom title column',
        'htmlAttributes' => [
            'class' => 'th-title-class'
        ]
    ],
    'valueColumnConfig' => [
        'label' => 'Custom value column',
        'htmlAttributes' => [
            'class' => 'th-value-class'
        ]
    ],
    'rowFields' => [
        [
            'attribute' => 'id', // REQUIRED if value is not defined. Attribute name to get row model data.
            'label' => 'ID', // Row label.
            'htmlAttributes' => [
                'class' => 'tr-class'
            ]
        ],
        [
            'label' => 'Active', // Row label.
            'value' => function ($model) { // You can set 'value' as a callback function to get a row data value dynamically.
                return '<span class="icon fas '.($model->active == 1 ? 'fa-check' : 'fa-times').'"></span>';
            },
            'format' => 'html', // To render row content without lossless of html tags, set 'html' formatter.
        ],
        [
            'label' => 'Url link', // Row label.
            'attribute' => 'url', // REQUIRED if value is not defined. Attribute name to get row model data.
            'format' => [ // Set special formatter. $model->{$this->attribute} will be inserted in to 'href' attribute of <a> tag.
                'class' => Itstructure\DetailView\Formatters\UrlFormatter::class, // REQUIRED. For this case it is necessary to set 'class'.
                'title' => 'Source', // title between a tags.
                'htmlAttributes' => [ // Html attributes for <a> tag.
                    'target' => '_blank'
                ]
            ]
        ],
        [
            'label' => 'Icon', // Row label.
            'value' => function ($model) { // You can set 'value' as a callback function to get a row data value dynamically.
                return $model->icon;
            },
            'format' => [ // Set special formatter. If $model->icon value is a url to image, it will be inserted in to 'src' attribute of <img> tag.
                'class' => Itstructure\DetailView\Formatters\ImageFormatter::class, // REQUIRED. For this case it is necessary to set 'class'.
                'htmlAttributes' => [ // Html attributes for <img> tag.
                    'width' => '100'
                ]
            ]
        ],
        'created_at', // Simple row setting by string.
    ]
];
@endphp
```

```php
@detailView($detailData)
```

## License

Copyright © 2021-2023 Andrey Girnik girnikandrey@gmail.com.

Licensed under the [MIT license](http://opensource.org/licenses/MIT). See LICENSE.txt for details.