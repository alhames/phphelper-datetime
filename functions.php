<?php

if (!function_exists('dt')) {
    /**
     * @param string|int|\DateTimeInterface|null $value
     */
    function dt($value = null): \PhpHelper\DateTime
    {
        if (null === $value) {
            return new \PhpHelper\DateTime();
        }

        if ($value instanceof \PhpHelper\DateTime) {
            return $value;
        }

        if ($value instanceof \DateTimeInterface) {
            return new \PhpHelper\DateTime($value->format('Y-m-d H:i:s.u'), $value->getTimezone());
        }

        if (is_int($value)) {
            return \PhpHelper\DateTime::createFromTimestamp($value);
        }

        if (!is_string($value)) {
            throw new \InvalidArgumentException('Date must be string, integer or DateTimeInterface.');
        }

        if (ctype_digit($value)) {
            return \PhpHelper\DateTime::createFromTimestamp((int) $value);
        }

        return new \PhpHelper\DateTime($value);
    }
}
