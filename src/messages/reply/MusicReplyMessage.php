<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\messages\reply;


class MusicReplyMessage extends BaseReplyMessage
{
    public $msgType = 'music';
    public $title;
    public $description;
    public $musicURL;
    public $hQMusicUrl;
    public $thumbMediaId;

    protected $xmlGroup = [
        'title' => 'Music',
        'description' => 'Music',
        'musicURL' => 'Music',
        'hQMusicUrl' => 'Music',
        'thumbMediaId' => 'Music',
    ];
}