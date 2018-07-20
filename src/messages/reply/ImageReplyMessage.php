<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\messages\reply;


class ImageReplyMessage extends BaseReplyMessage
{
    public $msgType = 'image';
    public $mediaId;

    protected $xmlGroup = [
        'mediaId' => 'Image',
    ];
}