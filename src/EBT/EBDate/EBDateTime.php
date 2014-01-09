<?php

/*
 * This file is a part of the EBDate library.
 *
 * (c) 2013 Ebidtech
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EBT\EBDate;

use EBT\EBDate\Exception\InvalidArgumentException;
use DateTime;
use DateTimeZone;

/**
 * EBDateTime
 */
class EBDateTime extends DateTime
{
    /**
     * @param string $time
     * @param mixed  $timezone
     */
    public function __construct($time = 'now', $timezone = null)
    {
        $timezone === null
            ? parent::__construct($time)
            : parent::__construct($time, static::safeCreateDateTimeZone($timezone));
    }

    /*
     |--------------------------------------------------------------------------
     | Create
     |--------------------------------------------------------------------------
     */

    /**
     * @return EBDateTime
     */
    public static function nowUTC()
    {
        return static::now(static::safeCreateDateTimeZoneUTC());
    }

    /**
     * @param $timezone
     *
     * @return EBDateTime
     */
    public static function now(DateTimezone $timezone = null)
    {
        return new static(null, $timezone);
    }

    /**
     * @param int $timestamp
     *
     * @return EBDateTime
     */
    public static function createFromTimestampUTC($timestamp)
    {
        return static::createFromTimestamp($timestamp, static::safeCreateDateTimeZoneUTC());
    }

    /**
     * @param int          $timestamp
     * @param DateTimeZone $timezone
     *
     * @return EBDateTime
     */
    public static function createFromTimestamp($timestamp, DateTimezone $timezone = null)
    {
        return static::now($timezone)->setTimestamp($timestamp);
    }

    /**
     * @param DateTime $dateTime
     *
     * @return EBDateTime
     */
    public static function fromDateTime(DateTime $dateTime)
    {
        return new static($dateTime->format(static::getDateTimeFormat()), $dateTime->getTimezone());
    }

    /**
     * @param string $format
     * @param string $time
     *
     * @return EBDateTime
     */
    public static function createFromFormatUTC($format, $time)
    {
        return static::createFromFormat($format, $time, self::safeCreateDateTimeZoneUTC());
    }

    /**
     * @param string $format
     * @param string $time
     * @param mixed   $timezone
     *
     * @return EBDateTime
     *
     * @throws InvalidArgumentException
     */
    public static function createFromFormat($format, $time, $timezone = null)
    {
        $dateTime = $timezone === null
            ? parent::createFromFormat($format, $time)
            : parent::createFromFormat($format, $time, static::safeCreateDateTimeZone($timezone));

        if ($dateTime instanceof DateTime) {
            return static::fromDateTime($dateTime);
        }

        $errors = static::getLastErrors();

        throw new InvalidArgumentException(
            sprintf(
                'Error creating date from format: "%s" details: "%s"',
                $format,
                json_encode($errors['errors'])
            )
        );
    }

    /**
     * @return DateTimeZone
     */
    protected static function safeCreateDateTimeZoneUTC()
    {
        return static::safeCreateDateTimeZone(new DateTimeZone('UTC'));
    }

    /**
     * Creates a DateTimeZone from a string or a DateTimeZone
     *
     * @param  DateTimeZone|string $object
     *
     * @return DateTimeZone
     *
     * @throws InvalidArgumentException
     */
    protected static function safeCreateDateTimeZone($object)
    {
        if ($object instanceof DateTimeZone) {
            return $object;
        }

        $objectStr = (string) $object;
        $timezone = @timezone_open((string) $object);

        if ($timezone === false) {
            throw new InvalidArgumentException(sprintf('Unknown or bad timezone "%s"', $objectStr));
        }

        return $timezone;
    }

    /*
     |--------------------------------------------------------------------------
     | Formats
     |--------------------------------------------------------------------------
     */

    /**
     * @return string
     */
    public static function getDateFormat()
    {
        return 'Y-m-d';
    }

    /**
     * @return string
     */
    public static function getDateTimeFormat()
    {
        return 'Y-m-d H:i:s';
    }

    /**
     * @return string ISO-8601 numeric representation of the day of the week
     *                1 (for Monday) through 7 (for Sunday)
     */
    public static function getNumericWeekdayFormat()
    {
        return 'N';
    }

    /**
     * @return string ISO-8601 week number of year, weeks starting on Monday
     *                Example: 42 (the 42nd week in the year)     */
    public static function getWeekNumberOfYearFormat()
    {
        return 'W';
    }

    /*
     |--------------------------------------------------------------------------
     | Export to a format
     |--------------------------------------------------------------------------
     */
    /**
     * @return string The date as string according to @see getDateFormat
     */
    public function formatAsDateString()
    {
        return $this->format(static::getDateFormat());
    }

    /**
     * @return string Date time formatted as string according to @see getDateTimeFormat
     */
    public function formatAsString()
    {
        return $this->format(static::getDateTimeFormat());
    }

    /**
     * Returns a date time formatted in a string that DB will accept.
     *
     * {@see formatAsString()} would be better to use date time as a string with offset, like:
     * ISO 8601 date (added in PHP 5)	2004-02-12T15:19:21+00:00
     *
     * But MySQL don't accept it:
     * {@link http://bugs.mysql.com/bug.php?id=27906}
     *
     * @return string
     */
    public function formatAsDb()
    {
        return $this->formatAsString();
    }

    /**
     * @return int Numeric weekday according to @see getNumericWeekdayFormat
     */
    public function formatAsNumericWeekday()
    {
        return (int) $this->format(static::getNumericWeekdayFormat());
    }

    /**
     * @return int Week number of year according to @see getWeekNumberOfYearFormat
     */
    public function formatAsWeekNumberOfYear()
    {
        return (int) $this->format(static::getWeekNumberOfYearFormat());
    }

    public static function create($year = null, $month = null, $day = null, $hour = null, $minute = null, $second = null, $tz = null)

}
