# Resized

This is the PHP client for resized.co, a realtime image resize manipulation service.

Requires PHP 8.2 or higher.

## Install

Via Composer

``` bash
$ composer require square1/resized
```

## Usage

``` php
    // Initialize and authenticate
    $resized = new \Square1\Resized\Resized('key', 'secret');

    // Override host if applicable
    $resized->setHost('https://img.resized.co');

    // Set the default failover image (used when $url is null, empty, or invalid)
    $resized->setDefaultImage('http://www.example.com/no-image.jpg');

    // Set default options
    $resized->setDefaultOptions(['quality' => 100]);

    // Process image resize. Parameters: ($url, $width, $height, $title, $options)
    // $url and $title accept string or null. Null $url falls back to the default image.
    // $width and $height accept int, string, or null. Null means no constraint on that dimension.
    $img = $resized->process('http://www.example.com/some-image.jpg', '100', '100', 'This is a title');

    // Integer dimensions are also accepted
    $img = $resized->process('http://www.example.com/some-image.jpg', 100, 200);

    // Constrain only width, leave height unconstrained
    $img = $resized->process('http://www.example.com/some-image.jpg', 100);

    // Pass null URL to always use the default image
    $img = $resized->process(null, 100, 200);
```

## Testing

``` bash
$ composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
