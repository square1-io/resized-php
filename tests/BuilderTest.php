<?php

namespace Square1\Resized\Test;

use PHPUnit\Framework\TestCase;
use Square1\Resized\Builder;
use Square1\Resized\Resized;

class BuilderTest extends TestCase
{
    private $resized;

    public function setUp(): void
    {
        $this->resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
    }

    public function testProcessBuilder()
    {
        $processBuilder = $this->resized->src('http://www.example.com/some-image-to-resize.jpg');

        $this->assertInstanceOf(Builder::class, $processBuilder);
    }

    public function testProcessBuilderFull()
    {
        $params = $this->resized->src('http://www.example.com/some-image-to-resize.jpg')
            ->width(100)
            ->height(100)
            ->output('webp')
            ->title('A nice title')
            ->options(['quality' => 80])
            ->getParams();

        $this->assertEquals($params['url'], 'http://www.example.com/some-image-to-resize.jpg');
        $this->assertEquals($params['width'], 100);
        $this->assertEquals($params['height'], 100);
        $this->assertEquals($params['options'], ['output' => 'webp', 'quality' => 80]);
        $this->assertEquals($params['title'], 'A nice title');
    }

    public function testProcessBuilderOptionsWillBeMerge()
    {
        $partialImage = $this->resized->src('http://www.example.com/some-image-to-resize.jpg')
            ->width(100)
            ->height(100)
            ->quality(70)
            ->output('webp')
            ->title('A nice title')
            ->options(['quality' => 80])
            ->options(['output' => 'jpeg'])
            ->getParams();

        $this->assertEquals($partialImage['options'], ['output' => 'jpeg', 'quality' => 80]);
    }

}
