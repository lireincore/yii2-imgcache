# Image effect, thumb and cache extension for Yii2

[![Latest Stable Version](https://poser.pugx.org/lireincore/yii2-imgcache/v/stable)](https://packagist.org/packages/lireincore/yii2-imgcache)
[![Total Downloads](https://poser.pugx.org/lireincore/yii2-imgcache/downloads)](https://packagist.org/packages/lireincore/yii2-imgcache)
[![License](https://poser.pugx.org/lireincore/yii2-imgcache/license)](https://packagist.org/packages/lireincore/yii2-imgcache)

## About

The [lireincore/imgcache](https://github.com/lireincore/imgcache) integration for Yii2 framework.

## Install

Add the `"lireincore/yii2-imgcache": "~0.1.0"` package to your `require` section in the `composer.json` file

or

``` bash
$ php composer.phar require lireincore/yii2-imgcache
```

## Usage

To use this extension, you need create the `imgcache.php` file in your `config` folder and add this example code:

```php
<?php

return [
    'srcdir' => '@app/files/uploads',
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
    'components' => [
        //....
        'imgcache'=> [
            'class' => 'LireinCore\Yii2ImgCache\ImgCache',
            'config' => require(__DIR__ . '/imgcache.php'),
        ],
    ],
];
```

Use in your code:

```php
//get thumb url for image '{srcdir}/blog/image.jpg' (preset 'origin')
$url = \Yii::$app->imgcache->url('origin', 'blog/image.jpg');
```

See `lireincore/imgcache` [README.md](https://github.com/lireincore/imgcache/blob/master/README.md) for more information about the available functions.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.