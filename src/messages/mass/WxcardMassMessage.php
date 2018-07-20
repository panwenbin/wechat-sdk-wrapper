<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\messages\mass;


class WxcardMassMessage extends BaseMassMessage
{
    public $msgtype = 'wxcard';
    public $card_id;

    protected $jsonGroup = [
        'card_id' => 'wxcard',
    ];
}