<?php declare(strict_types=1);

namespace DrdPlus\Tests\Index;

use DrdPlus\Index\FileTools;
use PHPUnit\Framework\TestCase;

class FileToolsTest extends TestCase
{

    /**
     * @test
     */
    public function I_can_get_human_readable_size()
    {
        self::assertSame('1kB', FileTools::getHumanReadableSize(1025));
        self::assertSame('1.95kB', FileTools::getHumanReadableSize(2000));
    }

    /**
     * @test
     */
    public function I_can_get_size_in_megabytes()
    {
        self::assertSame('0.33MB', FileTools::getHumanReadableSize(345000, 2, FileTools::MEGABYTE));
    }
}
