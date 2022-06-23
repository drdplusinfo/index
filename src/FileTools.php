<?php declare(strict_types=1);

namespace DrdPlus\Index;

use Granam\Strict\Object\StrictObject;

class FileTools extends StrictObject
{
    public const BYTE = 'B';
    public const KILOBYTE = 'kB';
    public const MEGABYTE = 'MB';
    public const GIGABYTE = 'GB';
    public const TERABYTE = 'TB';
    public const PENTABYTE = 'PB';
    public const EXABYTE = 'EB';
    public const ZETTABYTE = 'ZB';
    public const YOTTABYTE = 'YB';

    public const UNITS = [
        self::BYTE,
        self::KILOBYTE,
        self::MEGABYTE,
        self::GIGABYTE,
        self::TERABYTE,
        self::PENTABYTE,
        self::EXABYTE,
        self::ZETTABYTE,
        self::YOTTABYTE,
    ];

    public static function getFileSizeInMegabytes(string $filePath, int $precision = 2): string
    {
        return self::getHumanReadableFileSize($filePath, $precision, self::MEGABYTE);
    }

    /**
     * @param string $filePath
     * @param int $precision
     * @param string|null $requiredUnit
     * @return string
     * @throws \DrdPlus\Index\Exceptions\UnknownRequiredUnit
     */
    public static function getHumanReadableFileSize(string $filePath, int $precision = 2, string $requiredUnit = null): string
    {
        $fileSize = (int)filesize($filePath);
        return static::getHumanReadableSize($fileSize, $precision, $requiredUnit);
    }

    /**
     * @param int $bytes
     * @param int $precision
     * @param string|null $requiredUnit
     * @return string
     * @throws \DrdPlus\Index\Exceptions\UnknownRequiredUnit
     */
    public static function getHumanReadableSize(int $bytes, int $precision = 2, string $requiredUnit = null): string
    {
        $step = 1024;
        $unitIndex = 0;
        $size = $bytes;
        $requiredUnit = self::sanitizeRequiredUnit($requiredUnit);
        while (($requiredUnit !== null && $requiredUnit !== self::UNITS[$unitIndex])
            || ($requiredUnit === null && ($size / $step) > 0.9)
        ) {
            $size = $size / $step;
            $unitIndex++;
        }
        return (string)round($size, $precision) . ' ' . self::UNITS[$unitIndex];
    }

    /**
     * @param string|null $requiredUnit
     * @return string|null
     * @throws \DrdPlus\Index\Exceptions\UnknownRequiredUnit
     */
    private static function sanitizeRequiredUnit(?string $requiredUnit): ?string
    {
        if ($requiredUnit === null) {
            return null;
        }
        $unifiedRequiredUnit = strtoupper(trim($requiredUnit));
        foreach (self::UNITS as $unit) {
            if ($unifiedRequiredUnit === strtoupper($unit)) {
                return $unit;
            }
        }
        throw new \DrdPlus\Index\Exceptions\UnknownRequiredUnit(
            sprintf("Required unit '%s' is not known. Available are %s", $requiredUnit, implode(',', self::UNITS))
        );
    }
}
