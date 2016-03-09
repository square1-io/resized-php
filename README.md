# Resized

This is the PHP client for resized.co, a realtime image resize manipulation service.

## Install

Via Composer

``` bash
$ composer require square1/resized
```

## Usage

``` php

    $resized = new \Square1\Resized\Resized('key', 'secret');

    //Override host if applicable
    $resized->setHost('https://img.resized.co');

    //Set the default failover image
    $resized->setDefaultImage('http:/www.example.com/no-image.jpg');

    //Process image resize with the parameters: ($url, $width, $height, $title'
    $img = $resized->process('http://www.example.com/some-image-to-resize.jpg', '100', '100', 'This is a title');

```

## Testing

``` bash
$ composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
