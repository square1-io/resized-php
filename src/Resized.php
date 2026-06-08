<?php

namespace Square1\Resized;

use InvalidArgumentException;
use JsonException;

class Resized
{
    protected string $key;

    protected string $secret;

    private string $host = 'https://img.resized.co';

    private string $defaultImage = 'https://img.resized.co/no-image.png';

    private array $defaultOptions = [];

    private int $maxSlugLength = 100;

    public function __construct(string $key, string $secret)
    {
        if (strlen($secret) !== 47) {
            throw new InvalidArgumentException('Invalid Secret');
        }

        $this->key = $key;
        $this->secret = $secret;
    }

    public function setHost(string $url): void
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException('Invalid Host URL');
        }

        $this->host = $url;
    }

    public function setDefaultImage(string $url): void
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException('Invalid Default Image URL');
        }

        $this->defaultImage = $url;
    }

    public function setDefaultOptions(array $options): void
    {
        $this->defaultOptions = $options;
    }

    public function setMaxSlugLength(int $length): void
    {
        $this->maxSlugLength = $length;
    }

    /**
     * Width and height accept an empty string to indicate no constraint on that dimension.
     *
     * @throws JsonException
     */
    public function process(?string $url, int|string|null $width = null, int|string|null $height = null, ?string $title = '', array $options = []): string
    {
        if (empty($url) || filter_var($url, FILTER_VALIDATE_URL) === false) {
            $url = $this->defaultImage;
        }

        $data = json_encode([
            'url' => $url,
            'width' => $width,
            'height' => $height,
            'default' => $this->defaultImage,
            'options' => array_merge($this->defaultOptions, $options),
        ], JSON_THROW_ON_ERROR);

        $uri = base64_encode(json_encode([
            'data' => $data,
            'hash' => sha1($this->key . $this->secret . $data),
        ], JSON_THROW_ON_ERROR));

        $uri = str_replace(['+', '/'], ['-', '_'], $uri);

        $fullUrl = [
            $this->host,
            $this->key,
            $uri,
            $this->filename($url, $title),
        ];

        return implode('/', $fullUrl);
    }

    private function filename(?string $url, ?string $title = ''): ?string
    {
        if (! empty($title)) {
            $filename = $this->slug($title);
        } else {
            $filename = $this->slug(pathinfo($url, PATHINFO_FILENAME));
        }

        $extension = pathinfo($url, PATHINFO_EXTENSION);

        if (! empty($extension)) {
            $maxLength = $this->maxSlugLength - strlen('.' . $extension);

            return substr($filename, 0, $maxLength) . '.' . $extension;
        }

        return substr($filename, 0, $this->maxSlugLength);
    }

    private function slug(?string $str): string
    {
        $str = preg_replace('~[^\\pL\d]+~u', '-', $str);

        $str = trim($str, '-');

        $str = iconv('utf-8', 'us-ascii//TRANSLIT', $str);

        $str = strtolower($str);

        return preg_replace('~[^-\w]+~', '', $str);
    }
}
