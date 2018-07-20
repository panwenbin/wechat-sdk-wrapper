<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\messages\event;


class LocationEventMessage extends BaseEventMessage
{
    public $event = 'location';
    public $latitude;
    public $longitude;
    public $precision;
}