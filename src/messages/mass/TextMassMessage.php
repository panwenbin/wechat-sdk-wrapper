<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\messages\mass;


class TextMassMessage extends BaseMassMessage
{
    public $msgtype = 'text';
    public $content;

    protected $jsonGroup = [
        'content' => 'text',
    ];
}