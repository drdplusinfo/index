<?php
namespace DrdPlus\Tests\Index;

use PHPUnit\Framework\TestCase;

class ColorImagesTest extends TestCase
{
    /**
     * @test
     */
    public function I_can_get_color_image_to_every_monochrome_image(): void
    {
        $imagesDir = __DIR__ . '/../../../images';
        \exec("find $imagesDir -type f -name '*.png'", $output, $returnCode);
        self::assertSame(0, $returnCode);
        self::assertNotEmpty($output);
        $monochromeImages = [];
        $coloredImages = [];
        foreach ($output as $fileName) {
            $fileName = \basename($fileName);
            if (\strpos($fileName, 'monochrome') !== false) {
                $monochromeImages[] = $fileName;
            } elseif (\strpos($fileName, 'color') !== false) {
                $coloredImages[] = $fileName;
            }
        }
        self::assertNotEmpty($monochromeImages, 'No monochrome images found in ' . \var_export($output, true));
        foreach ($monochromeImages as $monochromeImage) {
            $expectedColorImage = \str_replace('monochrome', 'color', $monochromeImage);
            self::assertContains($expectedColorImage, $coloredImages, "Missing colored image $expectedColorImage");
        }
        self::assertCount(\count($monochromeImages), $coloredImages, 'Expected same count of monochrome and colored images');
    }
}
