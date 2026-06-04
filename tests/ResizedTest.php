<?php

namespace Square1\Resized\Test;

use InvalidArgumentException;
use JsonException;
use PHPUnit\Framework\TestCase;
use Square1\Resized\Resized;

class ResizedTest extends TestCase
{
    /**
     * Test invalid secret
     */
    public function testInvalidSecret(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid Secret');

        new Resized('key', 'secret-123456789');
    }

    /**
     * Test generating an image with a title
     */
    public function testInvalidDefaultURL(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid Default Image URL');

        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http:/www.example.com/no-image.jpg');
    }

    /**
     * Test invalid host
     */
    public function testInvalidHost(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid Host URL');

        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setHost('https:/img.resized.co');
    }

    /**
     * Test valid host
     * @throws JsonException
     */
    public function testValidHost(): void
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $resized->setHost('https://different.resized.co');
        $img = $resized->process('http://www.example.com/some-image-to-resize.jpg', '100', '100', 'A nice title');

        $this->assertEquals('https://different.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL3NvbWUtaW1hZ2UtdG8tcmVzaXplLmpwZ1wiLFwid2lkdGhcIjpcIjEwMFwiLFwiaGVpZ2h0XCI6XCIxMDBcIixcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjJjZDZjZjNkNjk2MDc0YjUyZmRjYWZmZWUwMjY5YmIxMTA0OTZjY2QifQ==/a-nice-title.jpg', $img);
    }

    /**
     * Test generating an image with a title
     * @throws JsonException
     */
    public function testEmptyURL(): void
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('', '100', '100', 'A nice title');

        $this->assertEquals('https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL25vLWltYWdlLmpwZ1wiLFwid2lkdGhcIjpcIjEwMFwiLFwiaGVpZ2h0XCI6XCIxMDBcIixcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjMxOWI2MzM1Zjc2Njg3NmQ1N2U4NjhjZTg0NGQwN2Y4ZThlZTQwZDkifQ==/a-nice-title.jpg', $img);
    }

    /**
     * Test generating an image with a title
     * @throws JsonException
     */
    public function testInvalidURL(): void
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('http:/www.example.com/some-image-to-resize.jpg', '100', '100', 'A nice title');

        $this->assertEquals('https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL25vLWltYWdlLmpwZ1wiLFwid2lkdGhcIjpcIjEwMFwiLFwiaGVpZ2h0XCI6XCIxMDBcIixcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjMxOWI2MzM1Zjc2Njg3NmQ1N2U4NjhjZTg0NGQwN2Y4ZThlZTQwZDkifQ==/a-nice-title.jpg', $img);
    }

    /**
     * Test generating an image with a title
     * @throws JsonException
     */
    public function testWithTitle(): void
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('http://www.example.com/some-image-to-resize.jpg', '100', '100', 'A nice title');

        $this->assertEquals('https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL3NvbWUtaW1hZ2UtdG8tcmVzaXplLmpwZ1wiLFwid2lkdGhcIjpcIjEwMFwiLFwiaGVpZ2h0XCI6XCIxMDBcIixcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjJjZDZjZjNkNjk2MDc0YjUyZmRjYWZmZWUwMjY5YmIxMTA0OTZjY2QifQ==/a-nice-title.jpg', $img);
    }

    /**
     * Test generating an image with no title
     * @throws JsonException
     */
    public function testWithNoTitle(): void
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('http://www.example.com/some-image-to-resize.jpg', '100', '100');

        $this->assertEquals('https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL3NvbWUtaW1hZ2UtdG8tcmVzaXplLmpwZ1wiLFwid2lkdGhcIjpcIjEwMFwiLFwiaGVpZ2h0XCI6XCIxMDBcIixcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjJjZDZjZjNkNjk2MDc0YjUyZmRjYWZmZWUwMjY5YmIxMTA0OTZjY2QifQ==/some-image-to-resize.jpg', $img);
    }

    /**
     * Test generating an image with width constrained
     * @throws JsonException
     */
    public function testConstrainWidth(): void
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('http://www.example.com/some-image-to-resize.jpg', '100');

        $this->assertEquals('https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL3NvbWUtaW1hZ2UtdG8tcmVzaXplLmpwZ1wiLFwid2lkdGhcIjpcIjEwMFwiLFwiaGVpZ2h0XCI6XCJcIixcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjM2YjEzNjljNmIyM2RhZmM4Y2VkZTQ1MTJiYzk5NTdlYWRjMDc1ZWMifQ==/some-image-to-resize.jpg', $img);
    }

    /**
     * Test generating an image with height constrained
     * @throws JsonException
     */
    public function testConstrainHeight(): void
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('http://www.example.com/some-image-to-resize.jpg', '', '100');

        $this->assertEquals('https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL3NvbWUtaW1hZ2UtdG8tcmVzaXplLmpwZ1wiLFwid2lkdGhcIjpcIlwiLFwiaGVpZ2h0XCI6XCIxMDBcIixcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjVhMWJmOTdjNDY1ZmU5YzEwNWIwMWZlODg1ZWIxNjM2MjRiMjZmZDAifQ==/some-image-to-resize.jpg', $img);
    }

    /**
     * Test empty contraints params
     * @throws JsonException
     */
    public function testEmptyConstraintParams(): void
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('http://www.example.com/some-image-to-resize.jpg');

        $this->assertEquals('https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL3NvbWUtaW1hZ2UtdG8tcmVzaXplLmpwZ1wiLFwid2lkdGhcIjpcIlwiLFwiaGVpZ2h0XCI6XCJcIixcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjMzMGZhODdhOWFmNGJmNTZiOWI2ODQ5NjAxNTZmMmYwNWRiY2Y0ZTUifQ==/some-image-to-resize.jpg', $img);
    }

    /**
     * Test no contraints params
     * @throws JsonException
     */
    public function testNoConstraintParams(): void
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('http://www.example.com/some-image-to-resize.jpg');

        $this->assertEquals('https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL3NvbWUtaW1hZ2UtdG8tcmVzaXplLmpwZ1wiLFwid2lkdGhcIjpcIlwiLFwiaGVpZ2h0XCI6XCJcIixcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjMzMGZhODdhOWFmNGJmNTZiOWI2ODQ5NjAxNTZmMmYwNWRiY2Y0ZTUifQ==/some-image-to-resize.jpg', $img);
    }
}
