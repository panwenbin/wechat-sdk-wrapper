<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat;


use panwenbin\wechat\messages\event\ClickEventMessage;
use panwenbin\wechat\messages\event\LocationEventMessage;
use panwenbin\wechat\messages\event\ScanEventMessage;
use panwenbin\wechat\messages\event\SubscribeEventMessage;
use panwenbin\wechat\messages\event\UnsubscribeEventMessage;
use panwenbin\wechat\messages\normal\ImageMessage;
use panwenbin\wechat\messages\normal\LinkMessage;
use panwenbin\wechat\messages\normal\LocationMessage;
use panwenbin\wechat\messages\normal\ShortVideoMessage;
use panwenbin\wechat\messages\normal\TextMessage;
use panwenbin\wechat\messages\normal\VideoMessage;
use panwenbin\wechat\messages\normal\VoiceMessage;

/**
 * 根据返回的xml组成生成对应Message对象
 * @package panwenbin\wechat
 */
class MessageBuilder
{
    protected $xml;

    /**
     * @return TextMessage|ImageMessage|VoiceMessage|VideoMessage|ShortVideoMessage|LocationMessage|LinkMessage|SubscribeEventMessage|UnsubscribeEventMessage|ScanEventMessage|LocationEventMessage|ClickEventMessage
     * @throws exceptions\MsgTypeNotMatchException
     */
    public function build()
    {
        $simpleXml = simplexml_load_string($this->xml, 'SimpleXMLElement', LIBXML_NOCDATA | LIBXML_NOBLANKS);
        $jsonArr = json_decode(json_encode($simpleXml), true);
        if (isset($jsonArr['MsgType'])) {
            if ($jsonArr['MsgType'] == 'event') {
                switch ($jsonArr['Event']) {
                    case 'subscribe':
                        return new SubscribeEventMessage($jsonArr);
                    case 'unsubscribe':
                        return new UnsubscribeEventMessage($jsonArr);
                    case 'SCAN':
                        return new ScanEventMessage($jsonArr);
                    case 'LOCATION':
                        return new LocationEventMessage($jsonArr);
                    case 'CLICK':
                        return new ClickEventMessage($jsonArr);
                }
            } else {
                switch ($jsonArr['MsgType']) {
                    case 'text':
                        return new TextMessage($jsonArr);
                    case 'image':
                        return new ImageMessage($jsonArr);
                    case 'voice':
                        return new VoiceMessage($jsonArr);
                    case 'video':
                        return new VideoMessage($jsonArr);
                    case 'shortvideo':
                        return new ShortVideoMessage($jsonArr);
                    case 'location':
                        return new LocationMessage($jsonArr);
                    case 'link':
                        return new LinkMessage($jsonArr);
                }
            }
        }
    }

    public function __construct(string $xml)
    {
        $this->xml = $xml;
    }
}