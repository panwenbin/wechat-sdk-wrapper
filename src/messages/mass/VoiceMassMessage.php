<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\messages\mass;


class VoiceMassMessage extends BaseMassMessage
{
    public $msgtype = 'voice';
    public $media_id;

    protected $jsonGroup = [
        'media_id' => 'voice',
    ];
}