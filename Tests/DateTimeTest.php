<?php

namespace PhpHelper\Tests;

use PhpHelper\DateTime;

class DateTimeTest extends \PHPUnit\Framework\TestCase
{
    private const DATE_EXAMPLE = '2020-01-01 10:10:10';

    public function testToString(): void
    {
        $date = new DateTime(self::DATE_EXAMPLE, new \DateTimeZone('UTC'));
        $this->assertSame('2020-01-01T10:10:10+00:00', (string) $date);
    }

    public function testCreateFromTimestamp(): void
    {
        $timestamp = mktime(10, 10, 10, 1, 1, 2020);
        $date = DateTime::createFromTimestamp($timestamp);
        $this->assertInstanceOf(DateTime::class, $date);
        $this->assertSame($timestamp, $date->getTimestamp());
    }

    public function testCreateStartOfHour(): void
    {
        $dateFromString = DateTime::createStartOfHour(self::DATE_EXAMPLE);
        $this->assertInstanceOf(DateTime::class, $dateFromString);
        $this->assertSame('2020-01-01 10:00:00', $dateFromString->format('Y-m-d H:i:s'));

        $dateObject = new \DateTime(self::DATE_EXAMPLE);
        $dateFromObject = DateTime::createStartOfHour($dateObject);
        $this->assertInstanceOf(DateTime::class, $dateFromObject);
        $this->assertSame('2020-01-01 10:00:00', $dateFromObject->format('Y-m-d H:i:s'));
        $this->assertSame(self::DATE_EXAMPLE, $dateObject->format('Y-m-d H:i:s'));
    }

    public function testCreateEndOfHour(): void
    {
        $dateFromString = DateTime::createEndOfHour(self::DATE_EXAMPLE);
        $this->assertInstanceOf(DateTime::class, $dateFromString);
        $this->assertSame('2020-01-01 10:59:59', $dateFromString->format('Y-m-d H:i:s'));

        $dateObject = new \DateTime(self::DATE_EXAMPLE);
        $dateFromObject = DateTime::createEndOfHour($dateObject);
        $this->assertInstanceOf(DateTime::class, $dateFromObject);
        $this->assertSame('2020-01-01 10:59:59', $dateFromObject->format('Y-m-d H:i:s'));
        $this->assertSame(self::DATE_EXAMPLE, $dateObject->format('Y-m-d H:i:s'));
    }

    public function testCreateStartOfDay(): void
    {
        $dateFromString = DateTime::createStartOfDay(self::DATE_EXAMPLE);
        $this->assertInstanceOf(DateTime::class, $dateFromString);
        $this->assertSame('2020-01-01 00:00:00', $dateFromString->format('Y-m-d H:i:s'));

        $dateObject = new \DateTime(self::DATE_EXAMPLE);
        $dateFromObject = DateTime::createStartOfDay($dateObject);
        $this->assertInstanceOf(DateTime::class, $dateFromObject);
        $this->assertSame('2020-01-01 00:00:00', $dateFromObject->format('Y-m-d H:i:s'));
        $this->assertSame(self::DATE_EXAMPLE, $dateObject->format('Y-m-d H:i:s'));
    }

    public function testCreateEndOfDay(): void
    {
        $dateFromString = DateTime::createEndOfDay(self::DATE_EXAMPLE);
        $this->assertInstanceOf(DateTime::class, $dateFromString);
        $this->assertSame('2020-01-01 23:59:59', $dateFromString->format('Y-m-d H:i:s'));

        $dateObject = new \DateTime(self::DATE_EXAMPLE);
        $dateFromObject = DateTime::createEndOfDay($dateObject);
        $this->assertInstanceOf(DateTime::class, $dateFromObject);
        $this->assertSame('2020-01-01 23:59:59', $dateFromObject->format('Y-m-d H:i:s'));
        $this->assertSame(self::DATE_EXAMPLE, $dateObject->format('Y-m-d H:i:s'));
    }

    public function testJsonSerialize(): void
    {
        $date = new DateTime(self::DATE_EXAMPLE, new \DateTimeZone('UTC'));
        $this->assertSame('"2020-01-01T10:10:10+00:00"', \json_encode($date));
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testGet(string $expected, \DateTimeInterface $date): void
    {
        $this->assertInstanceOf(DateTime::class, $date);
        $this->assertSame($expected, $date->format('Y-m-d H:i:s'));
    }

    public function getDataProvider(): array
    {
        $date = new DateTime(self::DATE_EXAMPLE, new \DateTimeZone('UTC'));

        return [
            ['2020-01-01 10:00:00', $date->getStartOfHour()],
            ['2020-01-01 10:59:59', $date->getEndOfHour()],
            ['2020-01-01 00:00:00', $date->getStartOfDay()],
            ['2020-01-01 23:59:59', $date->getEndOfDay()],
        ];
    }

    /**
     * @dataProvider functionDataProvider
     */
    public function testFunction(string $expected, $value): void
    {
        $date = dt($value);
        $this->assertInstanceOf(DateTime::class, $date);
        $this->assertSame($expected, $date->format('Y-m-d H:i:s.u'));
    }

    public function functionDataProvider(): array
    {
        return [
            ['2020-01-01 10:20:30.400000', '2020-01-01 10:20:30.40'],
            ['2020-01-01 10:20:30.400000', new DateTime('2020-01-01 10:20:30.40')],
            ['2020-01-01 10:20:30.400000', new \DateTime('2020-01-01 10:20:30.40')],
            ['2020-01-01 10:20:30.400000', new \DateTimeImmutable('2020-01-01 10:20:30.40')],
            ['2020-01-01 10:20:30.000000', mktime(10, 20, 30, 01, 01, 2020)],
            ['2020-01-01 10:20:30.000000', (string) mktime(10, 20, 30, 01, 01, 2020)],
            ['2020-01-02 10:20:30.400000', '2020-01-01 10:20:30.40 + 1 day'],
        ];
    }
}
