# Resized

This is the PHP client for resized.co, a realtime image resize manipulation service.

## Install

Via Composer

``` bash
$ composer require square1/resized
```

## Usage

``` php
    //Initialize and authenticate
    $resized = new \Square1\Resized\Resized('key', 'secret');

    //Override host if applicable
    $resized->setHost('https://img.resized.co');

    //Set the default failover image
    $resized->setDefaultImage('http:/www.example.com/no-image.jpg');

    //Set default options
    $resized->setDefaultOptions(['quality' => 100]);

    //Process image resize with the parameters: ($url, $width, $height, $title)
    $img = $resized->process('http://www.example.com/some-image.jpg', '100', '100', 'This is a title');
```

## Testing

``` bash
$ composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
