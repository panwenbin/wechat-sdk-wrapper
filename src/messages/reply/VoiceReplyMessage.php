<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\messages\reply;


class VoiceReplyMessage extends BaseReplyMessage
{
    public $msgType = 'voice';
    public $mediaId;

    protected $xmlGroup = [
        'mediaId' => 'Voice',
    ];
}