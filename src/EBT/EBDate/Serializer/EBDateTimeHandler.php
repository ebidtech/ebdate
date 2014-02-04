<?php

/*
 * This file is a part of the EBDate library.
 *
 * (c) 2013 Ebidtech
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EBT\EBDate\Serializer;

use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\Context;
use JMS\Serializer\JsonDeserializationVisitor;
use JMS\Serializer\XmlDeserializationVisitor;
use JMS\Serializer\VisitorInterface;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\XmlSerializationVisitor;
use EBT\EBDate\EBDateTime;

class EBDateTimeHandler implements SubscribingHandlerInterface
{
    /**
     * @var string
     */
    private $defaultFormat;

    /**
     * @var \DateTimeZone
     */
    private $defaultTimezone;

    /**
     * @var bool
     */
    private $xmlCData;

    /**
     * @return array
     */
    public static function getSubscribingMethods()
    {
        $methods = array();

        foreach (array('json', 'xml', 'yml') as $format) {
            $methods[] = array(
                'type' => 'EBT\EBDate\EBDateTime',
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format' => $format,
            );

            $methods[] = array(
                'type' => 'EBT\EBDate\EBDateTime',
                'format' => $format,
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'method' => 'serializeEBDateTime'
            );
        }

        return $methods;
    }

    /**
     * @param string $defaultFormat
     * @param string $defaultTimezone
     * @param bool   $xmlCData
     */
    public function __construct($defaultFormat = \DateTime::ISO8601, $defaultTimezone = 'UTC', $xmlCData = true)
    {
        $this->defaultFormat = $defaultFormat;
        $this->defaultTimezone = new \DateTimeZone($defaultTimezone);
        $this->xmlCData = $xmlCData;
    }

    /**
     * @param VisitorInterface $visitor
     * @param \DateTime        $date
     * @param array            $type
     * @param Context          $context
     *
     * @return mixed
     */
    public function serializeEBDateTime(VisitorInterface $visitor, \DateTime $date, array $type, Context $context)
    {
        return ($visitor instanceof XmlSerializationVisitor && false === $this->xmlCData)
            ? $visitor->visitSimpleString($date->format($this->getFormat($type)), $type, $context)
            : $visitor->visitString($date->format($this->getFormat($type)), $type, $context);
    }

    /**
     * @param XmlDeserializationVisitor $visitor
     * @param mixed                     $data
     * @param array                     $type
     *
     * @return EBDateTime|null
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function deserializeEBDateTimeFromXml(XmlDeserializationVisitor $visitor, $data, array $type)
    {
        $attributes = $data->attributes('xsi', true);

        return (isset($attributes['nil'][0]) && (string) $attributes['nil'][0] === 'true')
            ? null
            : $this->parseDateTime($data, $type);
    }

    /**
     * @param JsonDeserializationVisitor $visitor
     * @param mixed                      $data
     * @param array                      $type
     *
     * @return EBDateTime|null
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function deserializeEBDateTimeFromJson(JsonDeserializationVisitor $visitor, $data, array $type)
    {
        return null === $data ? null : $this->parseDateTime($data, $type);
    }

    /**
     * @param mixed $data
     * @param array $type
     *
     * @return EBDateTime
     */
    private function parseDateTime($data, array $type)
    {
        return EBDateTime::createFromFormat(
            $this->getFormat($type),
            (string) $data,
            isset($type['params'][1]) ? new \DateTimeZone($type['params'][1]) : $this->defaultTimezone
        );
    }

    /**
     * @param array $type
     *
     * @return string
     */
    private function getFormat(array $type)
    {
        return isset($type['params'][0]) ? $type['params'][0] : $this->defaultFormat;
    }
}
