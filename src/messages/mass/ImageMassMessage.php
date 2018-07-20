<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\messages\mass;


class ImageMassMessage extends BaseMassMessage
{
    public $msgtype = 'image';
    public $media_id;

    protected $jsonGroup = [
        'media_id' => 'image',
    ];
}