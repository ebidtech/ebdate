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

//    public function testUnrecognizedTimestamp()
//    {
//
//    }
}
