<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\messages\normal;


class VoiceMessage extends BaseNormalMessage
{
    public $msgType = 'voice';
    public $mediaId;
    public $format;
    public $recognition;
}