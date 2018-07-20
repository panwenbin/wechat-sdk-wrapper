<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\messages\mass;


class MpNewsMassMessage extends BaseMassMessage
{
    public $msgtype = 'mpnews';
    public $media_id;
    public $send_ignore_reprint = 0;

    protected $jsonGroup = [
        'media_id' => 'mpnews',
    ];
}