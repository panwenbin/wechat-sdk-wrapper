<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\messages\normal;


class LocationMessage extends BaseNormalMessage
{
    public $msgType = 'location';
    public $location_X;
    public $location_Y;
    public $scale;
    public $label;
}