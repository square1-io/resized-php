<?php

namespace Square1\Resized\Test;

use PHPUnit\Framework\TestCase;
use Square1\Resized\Resized;

class ResizedTest extends TestCase
{
    /**
     * Test invalid secret
     */
    public function testInvalidSecret()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid Secret');

        $resized = new Resized('key', 'secret-123456789');
    }

    /**
     * Test generating an image with a title
     */
    public function testInvalidDefaultURL()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid Default Image URL');

        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http:/www.example.com/no-image.jpg');
    }

    /**
     * Test invalid host
     */
    public function testInvalidHost()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid Host URL');

        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setHost('https:/img.resized.co');
    }

    /**
     * Test valid host
     */
    public function testValidHost()
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $resized->setHost('https://different.resized.co');
        $img = $resized->process('http://www.example.com/some-image-to-resize.jpg', '100', '100', 'A nice title');

        $this->assertEquals($img, 'https://different.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL3NvbWUtaW1hZ2UtdG8tcmVzaXplLmpwZ1wiLFwid2lkdGhcIjpcIjEwMFwiLFwiaGVpZ2h0XCI6XCIxMDBcIixcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjJjZDZjZjNkNjk2MDc0YjUyZmRjYWZmZWUwMjY5YmIxMTA0OTZjY2QifQ==/a-nice-title.jpg');
    }

    /**
     * Test generating an image with a title
     */
    public function testEmptyURL()
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('', '100', '100', 'A nice title');

        $this->assertEquals($img, 'https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL25vLWltYWdlLmpwZ1wiLFwid2lkdGhcIjpcIjEwMFwiLFwiaGVpZ2h0XCI6XCIxMDBcIixcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjMxOWI2MzM1Zjc2Njg3NmQ1N2U4NjhjZTg0NGQwN2Y4ZThlZTQwZDkifQ==/a-nice-title.jpg');
    }

    /**
     * Test generating an image with a title
     */
    public function testInvalidURL()
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('http:/www.example.com/some-image-to-resize.jpg', '100', '100', 'A nice title');

        $this->assertEquals($img, 'https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL25vLWltYWdlLmpwZ1wiLFwid2lkdGhcIjpcIjEwMFwiLFwiaGVpZ2h0XCI6XCIxMDBcIixcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjMxOWI2MzM1Zjc2Njg3NmQ1N2U4NjhjZTg0NGQwN2Y4ZThlZTQwZDkifQ==/a-nice-title.jpg');
    }

    /**
     * Test generating an image with a title
     */
    public function testWithTitle()
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('http://www.example.com/some-image-to-resize.jpg', '100', '100', 'A nice title');

        $this->assertEquals($img, 'https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL3NvbWUtaW1hZ2UtdG8tcmVzaXplLmpwZ1wiLFwid2lkdGhcIjpcIjEwMFwiLFwiaGVpZ2h0XCI6XCIxMDBcIixcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjJjZDZjZjNkNjk2MDc0YjUyZmRjYWZmZWUwMjY5YmIxMTA0OTZjY2QifQ==/a-nice-title.jpg');
    }

    /**
     * Test generating an image with no title
     */
    public function testWithNoTitle()
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('http://www.example.com/some-image-to-resize.jpg', '100', '100');

        $this->assertEquals($img, 'https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL3NvbWUtaW1hZ2UtdG8tcmVzaXplLmpwZ1wiLFwid2lkdGhcIjpcIjEwMFwiLFwiaGVpZ2h0XCI6XCIxMDBcIixcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjJjZDZjZjNkNjk2MDc0YjUyZmRjYWZmZWUwMjY5YmIxMTA0OTZjY2QifQ==/some-image-to-resize.jpg');
    }

    /**
     * Test generating an image with width constrained
     */
    public function testConstrainWidth()
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('http://www.example.com/some-image-to-resize.jpg', '100');

        $this->assertEquals($img, 'https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL3NvbWUtaW1hZ2UtdG8tcmVzaXplLmpwZ1wiLFwid2lkdGhcIjpcIjEwMFwiLFwiaGVpZ2h0XCI6XCJcIixcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjM2YjEzNjljNmIyM2RhZmM4Y2VkZTQ1MTJiYzk5NTdlYWRjMDc1ZWMifQ==/some-image-to-resize.jpg');
    }

    /**
     * Test generating an image with height constrained
     */
    public function testConstrainHeight()
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('http://www.example.com/some-image-to-resize.jpg', '', '100');

        $this->assertEquals($img, 'https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL3NvbWUtaW1hZ2UtdG8tcmVzaXplLmpwZ1wiLFwid2lkdGhcIjpcIlwiLFwiaGVpZ2h0XCI6XCIxMDBcIixcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjVhMWJmOTdjNDY1ZmU5YzEwNWIwMWZlODg1ZWIxNjM2MjRiMjZmZDAifQ==/some-image-to-resize.jpg');
    }

    /**
     * Test empty contraints params
     */
    public function testEmptyConstraintParams()
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('http://www.example.com/some-image-to-resize.jpg', '', '');

        $this->assertEquals($img, 'https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL3NvbWUtaW1hZ2UtdG8tcmVzaXplLmpwZ1wiLFwid2lkdGhcIjpcIlwiLFwiaGVpZ2h0XCI6XCJcIixcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjMzMGZhODdhOWFmNGJmNTZiOWI2ODQ5NjAxNTZmMmYwNWRiY2Y0ZTUifQ==/some-image-to-resize.jpg');
    }

    /**
     * Test no contraints params
     */
    public function testNoConstraintParams()
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('http://www.example.com/some-image-to-resize.jpg');

        $this->assertEquals($img, 'https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL3NvbWUtaW1hZ2UtdG8tcmVzaXplLmpwZ1wiLFwid2lkdGhcIjpcIlwiLFwiaGVpZ2h0XCI6XCJcIixcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjMzMGZhODdhOWFmNGJmNTZiOWI2ODQ5NjAxNTZmMmYwNWRiY2Y0ZTUifQ==/some-image-to-resize.jpg');
    }
}
