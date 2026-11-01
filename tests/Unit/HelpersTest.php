<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;

class HelpersTest extends TestCase
{
    public function test_media_url_helper(): void
    {
        $this->assertNull(media_url(null));
        $this->assertNull(media_url(''));
        $this->assertStringContainsString('storage/uploads/test.jpg', media_url('uploads/test.jpg'));

        // storage_image es alias de media_url
        $this->assertNull(storage_image(null));
        $this->assertStringContainsString('storage/uploads/test.jpg', storage_image('uploads/test.jpg'));
    }

    public function test_format_date_helper(): void
    {
        $this->assertEquals('', format_date(null));
        $this->assertEquals('', format_date(''));

        $date = Carbon::create(2026, 8, 26, 12, 0, 0);
        $this->assertEquals('26/08/2026', format_date($date));
        $this->assertEquals('26/08/2026', format_date('2026-08-26 12:00:00'));
        $this->assertEquals('26-08-2026', format_date($date, 'd-m-Y'));
    }
}
