<?php

namespace PhpHelper;

class DateTime extends \DateTimeImmutable implements \JsonSerializable
{
    public const MINUTE = 60;
    public const HOUR = 60 * self::MINUTE;
    public const DAY = 24 * self::HOUR;
    public const WEEK = 7 * self::DAY;
    public const MONTH = 30 * self::DAY;
    public const YEAR = 365 * self::DAY;

    public const FORMAT_MYSQL = 'Y-m-d H:i:s';
    public const FORMAT_W3C = 'Y-m-d\TH:i:sP';

    public function __toString()
    {
        return $this->format(self::FORMAT_W3C);
    }

    public static function createFromTimestamp(int $timestamp): self
    {
        return (new static())->setTimestamp($timestamp);
    }

    /**
     * @param \DateTimeInterface|string $date
     */
    public static function createStartOfHour($date = 'now'): self
    {
        if (!$date instanceof \DateTimeInterface) {
            $date = new static($date);
            $date = $date->setTime($date->format('H'), 0, 0, 0);
        } else {
            $date = new static($date->format('Y-m-d H:00:00.0'), $date->getTimezone());
        }

        return $date;
    }

    /**
     * @param \DateTimeInterface|string $date
     */
    public static function createEndOfHour($date = 'now'): self
    {
        if (!$date instanceof \DateTimeInterface) {
            $date = new static($date);
            $date = $date->setTime($date->format('H'), 59, 59, 999999);
        } else {
            $date = new static($date->format('Y-m-d H:59:59.999999'), $date->getTimezone());
        }

        return $date;
    }

    /**
     * @param \DateTimeInterface|string $date
     */
    public static function createStartOfDay($date = 'now'): self
    {
        if (!$date instanceof \DateTimeInterface) {
            $date = new static($date);
            $date = $date->setTime(0, 0, 0, 0);
        } else {
            $date = new static($date->format('Y-m-d 00:00:00.0'), $date->getTimezone());
        }

        return $date;
    }

    /**
     * @param \DateTimeInterface|string $date
     */
    public static function createEndOfDay($date = 'now'): self
    {
        if (!$date instanceof \DateTimeInterface) {
            $date = new static($date);
            $date = $date->setTime(23, 59, 59, 999999);
        } else {
            $date = new static($date->format('Y-m-d 23:59:59.999999'), $date->getTimezone());
        }

        return $date;
    }

    public function jsonSerialize()
    {
        return $this->format(self::FORMAT_W3C);
    }

    public function getStartOfHour(): self
    {
        return $this->setTime($this->format('H'), 0, 0, 0);
    }

    public function getEndOfHour(): self
    {
        return $this->setTime($this->format('H'), 59, 59, 999999);
    }

    public function getStartOfDay(): self
    {
        return $this->setTime(0, 0, 0, 0);
    }

    public function getEndOfDay(): self
    {
        return $this->setTime(23, 59, 59, 999999);
    }
}
