<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\messages\mass;


class MpVideoMassMessage extends BaseMassMessage
{
    public $msgtype = 'mpvideo';
    public $media_id;
    public $title;
    public $description;

    protected $jsonGroup = [
        'media_id' => 'mpvideo',
        'title' => 'mpvideo',
        'description' => 'mpvideo',
    ];
}