<?php

/*
 * This file is a part of the EBDate library.
 *
 * (c) 2013 Ebidtech
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EBT\EBDate\Tests;

use EBT\EBDate\EBDateTime;
use DateTime;
use DateTimeZone;

/**
 * EBDateTimeTest
 */
class EBDateTimeTest extends TestCase
{
    public function testConstruct()
    {
        $dateTime = new EBDateTime(null, 'Asia/Baku');
        $this->assertEquals('Asia/Baku', $dateTime->getTimezone()->getName());
    }

    public function testCreateFromTimestamp()
    {
        $timestamp = time();

        $dateTime = EBDateTime::createFromTimestampUTC($timestamp);
        $this->assertEquals('UTC', $dateTime->getTimezone()->getName());

        $dateTime = EBDateTime::createFromTimestamp($timestamp, new DateTimeZone('Europe/London'));
        $this->assertEquals('Europe/London', $dateTime->getTimezone()->getName());
    }

    public function testNowUTC()
    {
        $now = EBDateTime::nowUTC();
        $this->assertEquals('UTC', $now->getTimezone()->getName());
    }

    /**
     * @expectedException \EBT\EBDate\Exception\InvalidArgumentException
     */
    public function testUnrecognizedTimestamp()
    {
        new EBDateTime(null, 'bad timezone');
    }

    public function testFromDateTime()
    {
        $dateTime = new DateTime();
        $ebDateTime = EBDateTime::fromDateTime($dateTime);

        $this->assertEquals($dateTime->getTimestamp(), $ebDateTime->getTimestamp());
        $this->assertEquals($dateTime->getTimezone(), $ebDateTime->getTimezone());
    }

    public function testCreateFromFormatInvalid()
    {
        $date = EBDateTime::createFromFormat('Y-m-d', '1999-04-25');
        $this->assertInstanceOf('EBT\EBDate\EBDateTime', $date);
    }

    public function testFormats()
    {
        $date = EBDateTime::createFromFormatUTC('Y-m-d H:i:s', '2014-01-09 19:30:20');

        $this->assertEquals('UTC', $date->getTimezone()->getName());
        $this->assertEquals('2014-01-09 19:30:20', $date->formatAsString());
        $this->assertEquals('2014-01-09 19:30:20', $date->formatAsDb());
        $this->assertEquals('2014-01-09', $date->formatAsDateString());
        $weekday = $date->formatAsNumericWeekday();
        $this->assertInternalType('integer', $weekday);
        $this->assertEquals(4, $weekday);
        $weekNumber = $date->formatAsWeekNumberOfYear();
        $this->assertInternalType('integer', $weekNumber);
        $this->assertEquals(2, $weekNumber);
    }
}
