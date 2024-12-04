<?php

namespace Square1\Resized;

class Builder
{
    private $resized;

    private $params;

    public function __construct(
        Resized $resized,
        string $url
    )
    {
        $this->resized = $resized;
        $this->params['url'] = $url;
    }

    public function getParams() : array
    {
        return $this->params;
    }

    public function width($width): self
    {
        $this->params['width'] = $width;
        return $this;
    }

    public function height($height): self
    {
        $this->params['height'] = $height;
        return $this;
    }

    public function title($title): self
    {
        $this->params['title'] = $title;
        return $this;
    }

    public function output($output): self
    {
        $this->params['options']['output'] = $output;
        return $this;
    }

    public function quality($quality): self
    {
        $this->params['options']['quality'] = $quality;
        return $this;
    }

    public function options(array $options): self
    {
        $this->params['options'] = $this->mergeOptions($options);
        return $this;
    }

    private function mergeOptions(array $options) : array
    {
        return array_merge(
            $this->params['options'],
            $options
        );

    }

    public function url(): string
    {
        return $this->resized->process(
            $this->params['url'],
            $this->params['width'] ?? '',
            $this->params['height'] ?? '',
            $this->params['title'] ?? '',
            $this->params['options'] ?? []
        );
    }


}
