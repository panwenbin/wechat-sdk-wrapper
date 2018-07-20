<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\messages\event;


class ScanEventMessage extends BaseEventMessage
{
    public $event = 'scan';
    public $eventKey; // 事件KEY值，是一个32位无符号整数，即创建二维码时的二维码scene_id
    public $ticket; // 二维码的ticket，可用来换取二维码图片
}