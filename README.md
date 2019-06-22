# Image effect, thumb and cache extension for Yii2

[![Latest Stable Version](https://poser.pugx.org/lireincore/yii2-imgcache/v/stable)](https://packagist.org/packages/lireincore/yii2-imgcache)
[![Total Downloads](https://poser.pugx.org/lireincore/yii2-imgcache/downloads)](https://packagist.org/packages/lireincore/yii2-imgcache)
[![License](https://poser.pugx.org/lireincore/yii2-imgcache/license)](https://packagist.org/packages/lireincore/yii2-imgcache)

## About

The [lireincore/imgcache](https://github.com/lireincore/imgcache) integration for Yii2 framework.

## Install

Add the `"lireincore/yii2-imgcache": "^0.5"` package to your `require` section in the `composer.json` file

or

``` bash
$ php composer.phar require lireincore/yii2-imgcache
```

## Usage

To use this extension, you need to create the `imgcache.php` file in your `config` folder and add this code:

```php
<?php

return [
    'srcdir' => '@app/files/images',
    'destdir' => '@webroot/thumbs',
    'webdir' => '@webroot',
    'baseurl' => '@web',
    //....
    'presets' => [
        'origin' => [
            'effects' => [
                //add the effects you need
                //....
            ],
        ],
    ],
];
```

See `lireincore/imgcache` [README.md](https://github.com/lireincore/imgcache/blob/master/README.md) for more information about the available effects and other config options.

Also add the following code in your Yii2 application configuration:

```php
$config = [
    //....
    'container' => [
        //....
        'singletons'  => [
            //....
            LireinCore\Yii2ImgCache\ImgCache::class => [
                ['class' => LireinCore\Yii2ImgCache\ImgCache::class],
                [
                    require(__DIR__ . '/imgcache.php'),
                ]
            ],
        ]
    ],
];
```

Use in your code:

```php
use LireinCore\Yii2ImgCache\ImgCache;

$imgCache = Yii::$container->get(ImgCache::class);

// get thumb url for image '{srcdir}/blog/image.jpg' (preset 'origin')
$url = $imgcache->url('blog/image.jpg', 'origin');


// get thumb url for image '{srcdir}/blog/image.jpg' (preset 'origin')
$url = \Yii::$app->imgcache->url('blog/image.jpg', 'origin');
```

See `lireincore/imgcache` [README.md](https://github.com/lireincore/imgcache/blob/master/README.md) for more information about the available functions.

## License

This project is licensed under the MIT License - see the [License File](LICENSE) file for details
