<?php

namespace Square1\Resized\Test;

use InvalidArgumentException;
use JsonException;
use PHPUnit\Framework\TestCase;
use Square1\Resized\Resized;

class ResizedTest extends TestCase
{
    public function testInvalidSecret(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid Secret');

        new Resized('key', 'secret-123456789');
    }

    public function testInvalidDefaultURL(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid Default Image URL');

        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http:/www.example.com/no-image.jpg');
    }

    public function testInvalidHost(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid Host URL');

        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setHost('https:/img.resized.co');
    }

    public function testValidHost(): void
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $resized->setHost('https://different.resized.co');
        $img = $resized->process('http://www.example.com/some-image-to-resize.jpg', '100', '100', 'A nice title');

        $this->assertEquals('https://different.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL3NvbWUtaW1hZ2UtdG8tcmVzaXplLmpwZ1wiLFwid2lkdGhcIjpcIjEwMFwiLFwiaGVpZ2h0XCI6XCIxMDBcIixcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjJjZDZjZjNkNjk2MDc0YjUyZmRjYWZmZWUwMjY5YmIxMTA0OTZjY2QifQ==/a-nice-title.jpg', $img);
    }

    public function testEmptyURL(): void
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('', '100', '100', 'A nice title');

        $this->assertEquals('https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL25vLWltYWdlLmpwZ1wiLFwid2lkdGhcIjpcIjEwMFwiLFwiaGVpZ2h0XCI6XCIxMDBcIixcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjMxOWI2MzM1Zjc2Njg3NmQ1N2U4NjhjZTg0NGQwN2Y4ZThlZTQwZDkifQ==/a-nice-title.jpg', $img);
    }

    public function testInvalidURL(): void
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('http:/www.example.com/some-image-to-resize.jpg', '100', '100', 'A nice title');

        $this->assertEquals('https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL25vLWltYWdlLmpwZ1wiLFwid2lkdGhcIjpcIjEwMFwiLFwiaGVpZ2h0XCI6XCIxMDBcIixcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjMxOWI2MzM1Zjc2Njg3NmQ1N2U4NjhjZTg0NGQwN2Y4ZThlZTQwZDkifQ==/a-nice-title.jpg', $img);
    }

    public function testWithTitle(): void
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('http://www.example.com/some-image-to-resize.jpg', '100', '100', 'A nice title');

        $this->assertEquals('https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL3NvbWUtaW1hZ2UtdG8tcmVzaXplLmpwZ1wiLFwid2lkdGhcIjpcIjEwMFwiLFwiaGVpZ2h0XCI6XCIxMDBcIixcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjJjZDZjZjNkNjk2MDc0YjUyZmRjYWZmZWUwMjY5YmIxMTA0OTZjY2QifQ==/a-nice-title.jpg', $img);
    }

    public function testWithNoTitle(): void
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('http://www.example.com/some-image-to-resize.jpg', '100', '100');

        $this->assertEquals('https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL3NvbWUtaW1hZ2UtdG8tcmVzaXplLmpwZ1wiLFwid2lkdGhcIjpcIjEwMFwiLFwiaGVpZ2h0XCI6XCIxMDBcIixcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjJjZDZjZjNkNjk2MDc0YjUyZmRjYWZmZWUwMjY5YmIxMTA0OTZjY2QifQ==/some-image-to-resize.jpg', $img);
    }

    public function testConstrainWidth(): void
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('http://www.example.com/some-image-to-resize.jpg', '100');

        $this->assertEquals('https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL3NvbWUtaW1hZ2UtdG8tcmVzaXplLmpwZ1wiLFwid2lkdGhcIjpcIjEwMFwiLFwiaGVpZ2h0XCI6bnVsbCxcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6ImZlNjY3MjEyNGE1M2Y4MWVkY2JhNzA3OTk5MjFlMDYxN2QxYWVlZTQifQ==/some-image-to-resize.jpg', $img);
    }

    public function testConstrainHeight(): void
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('http://www.example.com/some-image-to-resize.jpg', '', '100');

        $this->assertEquals('https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL3NvbWUtaW1hZ2UtdG8tcmVzaXplLmpwZ1wiLFwid2lkdGhcIjpcIlwiLFwiaGVpZ2h0XCI6XCIxMDBcIixcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjVhMWJmOTdjNDY1ZmU5YzEwNWIwMWZlODg1ZWIxNjM2MjRiMjZmZDAifQ==/some-image-to-resize.jpg', $img);
    }

    public function testEmptyConstraintParams(): void
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('http://www.example.com/some-image-to-resize.jpg');

        $this->assertEquals('https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL3NvbWUtaW1hZ2UtdG8tcmVzaXplLmpwZ1wiLFwid2lkdGhcIjpudWxsLFwiaGVpZ2h0XCI6bnVsbCxcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjgyMzAzZDljNmVmN2E3MmIyYjliMzZmNjA5MjBlODZiMzI0YzFhNjYifQ==/some-image-to-resize.jpg', $img);
    }

    public function testNoConstraintParams(): void
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('http://www.example.com/some-image-to-resize.jpg');

        $this->assertEquals('https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL3NvbWUtaW1hZ2UtdG8tcmVzaXplLmpwZ1wiLFwid2lkdGhcIjpudWxsLFwiaGVpZ2h0XCI6bnVsbCxcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjgyMzAzZDljNmVmN2E3MmIyYjliMzZmNjA5MjBlODZiMzI0YzFhNjYifQ==/some-image-to-resize.jpg', $img);
    }

    public function testNullUrl(): void
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process(null);

        $this->assertEquals('https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL25vLWltYWdlLmpwZ1wiLFwid2lkdGhcIjpudWxsLFwiaGVpZ2h0XCI6bnVsbCxcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjA5YWQ4MzE3N2QwZTJmNjFhZWJhMmY0OGM0OTlmMjRkM2QxMDE3NWEifQ==/no-image.jpg', $img);
    }

    public function testNullUrlWithTitle(): void
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process(null, '100', '100', 'A nice title');

        $this->assertEquals('https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL25vLWltYWdlLmpwZ1wiLFwid2lkdGhcIjpcIjEwMFwiLFwiaGVpZ2h0XCI6XCIxMDBcIixcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjMxOWI2MzM1Zjc2Njg3NmQ1N2U4NjhjZTg0NGQwN2Y4ZThlZTQwZDkifQ==/a-nice-title.jpg', $img);
    }

    public function testNullWidth(): void
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('http://www.example.com/some-image-to-resize.jpg', null, '100');

        $this->assertEquals('https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL3NvbWUtaW1hZ2UtdG8tcmVzaXplLmpwZ1wiLFwid2lkdGhcIjpudWxsLFwiaGVpZ2h0XCI6XCIxMDBcIixcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjNjZjAwYTZiZWU2N2ZkOTZjMzBkMzZkOGE5ZjRiMzI4ZDA2ZGMyYTgifQ==/some-image-to-resize.jpg', $img);
    }

    public function testNullTitle(): void
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('http://www.example.com/some-image-to-resize.jpg', '100', '100', null);

        $this->assertEquals('https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL3NvbWUtaW1hZ2UtdG8tcmVzaXplLmpwZ1wiLFwid2lkdGhcIjpcIjEwMFwiLFwiaGVpZ2h0XCI6XCIxMDBcIixcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjJjZDZjZjNkNjk2MDc0YjUyZmRjYWZmZWUwMjY5YmIxMTA0OTZjY2QifQ==/some-image-to-resize.jpg', $img);
    }

    public function testNullWidthAndHeight(): void
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('http://www.example.com/some-image-to-resize.jpg', null, null);

        $this->assertEquals('https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL3NvbWUtaW1hZ2UtdG8tcmVzaXplLmpwZ1wiLFwid2lkdGhcIjpudWxsLFwiaGVpZ2h0XCI6bnVsbCxcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjgyMzAzZDljNmVmN2E3MmIyYjliMzZmNjA5MjBlODZiMzI0YzFhNjYifQ==/some-image-to-resize.jpg', $img);
    }

    public function testNullHeight(): void
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('http://www.example.com/some-image-to-resize.jpg', '100', null);

        $this->assertEquals('https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL3NvbWUtaW1hZ2UtdG8tcmVzaXplLmpwZ1wiLFwid2lkdGhcIjpcIjEwMFwiLFwiaGVpZ2h0XCI6bnVsbCxcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6ImZlNjY3MjEyNGE1M2Y4MWVkY2JhNzA3OTk5MjFlMDYxN2QxYWVlZTQifQ==/some-image-to-resize.jpg', $img);
    }

    public function testNullUrlNullTitle(): void
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process(null, '100', '100', null);

        $this->assertEquals('https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL25vLWltYWdlLmpwZ1wiLFwid2lkdGhcIjpcIjEwMFwiLFwiaGVpZ2h0XCI6XCIxMDBcIixcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjMxOWI2MzM1Zjc2Njg3NmQ1N2U4NjhjZTg0NGQwN2Y4ZThlZTQwZDkifQ==/no-image.jpg', $img);
    }

    public function testAllNull(): void
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process(null, null, null, null);

        $this->assertEquals('https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL25vLWltYWdlLmpwZ1wiLFwid2lkdGhcIjpudWxsLFwiaGVpZ2h0XCI6bnVsbCxcImRlZmF1bHRcIjpcImh0dHA6XFxcL1xcXC93d3cuZXhhbXBsZS5jb21cXFwvbm8taW1hZ2UuanBnXCIsXCJvcHRpb25zXCI6W119IiwiaGFzaCI6IjA5YWQ4MzE3N2QwZTJmNjFhZWJhMmY0OGM0OTlmMjRkM2QxMDE3NWEifQ==/no-image.jpg', $img);
    }

    public function testIntWidth(): void
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('http://www.example.com/some-image-to-resize.jpg', 100);

        $this->assertEquals('https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL3NvbWUtaW1hZ2UtdG8tcmVzaXplLmpwZ1wiLFwid2lkdGhcIjoxMDAsXCJoZWlnaHRcIjpudWxsLFwiZGVmYXVsdFwiOlwiaHR0cDpcXFwvXFxcL3d3dy5leGFtcGxlLmNvbVxcXC9uby1pbWFnZS5qcGdcIixcIm9wdGlvbnNcIjpbXX0iLCJoYXNoIjoiMWIzYmY4NjIxNGJhNzJmMWUyMGZhMmE4ODNhYmRhYTZiMzFhZWRlMyJ9/some-image-to-resize.jpg', $img);
    }

    public function testIntHeight(): void
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('http://www.example.com/some-image-to-resize.jpg', null, 100);

        $this->assertEquals('https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL3NvbWUtaW1hZ2UtdG8tcmVzaXplLmpwZ1wiLFwid2lkdGhcIjpudWxsLFwiaGVpZ2h0XCI6MTAwLFwiZGVmYXVsdFwiOlwiaHR0cDpcXFwvXFxcL3d3dy5leGFtcGxlLmNvbVxcXC9uby1pbWFnZS5qcGdcIixcIm9wdGlvbnNcIjpbXX0iLCJoYXNoIjoiOWJiYjM1OGM0Y2JkYjI5ODRjZThiNTNmN2RjMTFjNjU1ZDdhMDlhZCJ9/some-image-to-resize.jpg', $img);
    }

    public function testIntWidthAndHeight(): void
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('http://www.example.com/some-image-to-resize.jpg', 100, 200);

        $this->assertEquals('https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL3NvbWUtaW1hZ2UtdG8tcmVzaXplLmpwZ1wiLFwid2lkdGhcIjoxMDAsXCJoZWlnaHRcIjoyMDAsXCJkZWZhdWx0XCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL25vLWltYWdlLmpwZ1wiLFwib3B0aW9uc1wiOltdfSIsImhhc2giOiIyODU3MjljZGQ5MzEyMDgwNWUyNDQ4ZDhiNjJjZDZkMTNjZDhmNDA1In0=/some-image-to-resize.jpg', $img);
    }

    public function testIntWidthAndHeightWithTitle(): void
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('http://www.example.com/some-image-to-resize.jpg', 100, 200, 'A nice title');

        $this->assertEquals('https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL3NvbWUtaW1hZ2UtdG8tcmVzaXplLmpwZ1wiLFwid2lkdGhcIjoxMDAsXCJoZWlnaHRcIjoyMDAsXCJkZWZhdWx0XCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL25vLWltYWdlLmpwZ1wiLFwib3B0aW9uc1wiOltdfSIsImhhc2giOiIyODU3MjljZGQ5MzEyMDgwNWUyNDQ4ZDhiNjJjZDZkMTNjZDhmNDA1In0=/a-nice-title.jpg', $img);
    }

    public function testIntWidthStringHeight(): void
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process('http://www.example.com/some-image-to-resize.jpg', 100, '200');

        $this->assertEquals('https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL3NvbWUtaW1hZ2UtdG8tcmVzaXplLmpwZ1wiLFwid2lkdGhcIjoxMDAsXCJoZWlnaHRcIjpcIjIwMFwiLFwiZGVmYXVsdFwiOlwiaHR0cDpcXFwvXFxcL3d3dy5leGFtcGxlLmNvbVxcXC9uby1pbWFnZS5qcGdcIixcIm9wdGlvbnNcIjpbXX0iLCJoYXNoIjoiYzA5NWI1OGRlNmViZTNjMjFkNWZhNWUzMzFkNmM1MWIwYjE5ZThhZSJ9/some-image-to-resize.jpg', $img);
    }

    public function testNullUrlIntWidthAndHeight(): void
    {
        $resized = new Resized('key', 'secret-d0be2dc421be4fcd0172e5afceea3970e2f3d940');
        $resized->setDefaultImage('http://www.example.com/no-image.jpg');
        $img = $resized->process(null, 100, 200);

        $this->assertEquals('https://img.resized.co/key/eyJkYXRhIjoie1widXJsXCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL25vLWltYWdlLmpwZ1wiLFwid2lkdGhcIjoxMDAsXCJoZWlnaHRcIjoyMDAsXCJkZWZhdWx0XCI6XCJodHRwOlxcXC9cXFwvd3d3LmV4YW1wbGUuY29tXFxcL25vLWltYWdlLmpwZ1wiLFwib3B0aW9uc1wiOltdfSIsImhhc2giOiIyMzQzN2M3Y2FmNWIwN2NiNjI1MjFmMjNlMjNhYmUwZmY5YTUxNzM0In0=/no-image.jpg', $img);
    }
}
