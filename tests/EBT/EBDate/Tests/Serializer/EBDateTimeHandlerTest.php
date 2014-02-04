<?php

/*
 * This file is a part of the EBDate library.
 *
 * (c) 2013 Ebidtech
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EBT\EBDate\Tests\Serializer;

use EBT\EBDate\Tests\TestCase;
use JMS\Serializer\SerializerBuilder;
use EBT\EBDate\EBDateTime;
use JMS\Serializer\Handler\HandlerRegistry;
use EBT\EBDate\Serializer\EBDateTimeHandler;
use JMS\Serializer\SerializerInterface;

/**
 * EBDateTimeHandlerTest
 */
class EBDateTimeHandlerTest extends TestCase
{
    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->serializer = SerializerBuilder::create()->configureHandlers(
            function (HandlerRegistry $registry) {
                $registry->registerSubscribingHandler(new EBDateTimeHandler());
            }
        )->build();
    }

    public function testSerializeDeserialize()
    {
        $dateStr = '2014-01-09 19:20:30';
        $date = EBDateTime::createFromFormat(EBDateTime::getDateTimeFormat(), $dateStr);

        $dateJson = $this->serializer->serialize($date, 'json');
        $this->assertEquals('"2014-01-09T19:20:30+0000"', $dateJson);

        $dateXml = $this->serializer->serialize($date, 'xml');
        $this->assertEquals(
            "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<result><![CDATA[2014-01-09T19:20:30+0000]]></result>\n",
            $dateXml
        );

        /** @var EBDateTime $dateFromJson */
        $dateFromJson = $this->serializer->deserialize($dateJson, 'EBT\EBDate\EBDateTime', 'json');
        $this->assertEquals(
            $dateStr,
            $dateFromJson->formatAsString()
        );

        /** @var EBDateTime $dateFromXml */
        $dateFromXml = $this->serializer->deserialize($dateXml, 'EBT\EBDate\EBDateTime', 'xml');
        $this->assertEquals(
            $dateStr,
            $dateFromXml->formatAsString()
        );
    }
}
