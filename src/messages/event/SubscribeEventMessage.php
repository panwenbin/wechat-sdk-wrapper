<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\messages\event;


class SubscribeEventMessage extends BaseEventMessage
{
    public $event = 'subscribe';
    public $eventKey; // 事件KEY值，qrscene_为前缀，后面为二维码的参数值。只在扫描二维码关注时有
    public $ticket; // 二维码的ticket，可用来换取二维码图片。只在扫描二维码关注时有
}