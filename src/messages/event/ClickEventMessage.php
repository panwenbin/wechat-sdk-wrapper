<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\messages\event;


class ClickEventMessage extends BaseEventMessage
{
    public $eventKey; // 事件KEY值，与自定义菜单接口中KEY值对应
}