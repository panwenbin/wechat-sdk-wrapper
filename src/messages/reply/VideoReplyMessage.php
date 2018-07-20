<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\messages\reply;


class VideoReplyMessage extends BaseReplyMessage
{
    public $msgType = 'video';
    public $mediaId;
    public $title;
    public $description;

    protected $xmlGroup = [
        'mediaId' => 'Video',
        'title' => 'Video',
        'description' => 'Video',
    ];
}