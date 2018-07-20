<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

use panwenbin\wechat\MessageBuilder;
use panwenbin\wechat\messages\normal\TextMessage;
use panwenbin\wechat\messages\normal\VoiceMessage;
use panwenbin\wechat\messages\reply\TextReplyMessage;

$xml = file_get_contents('php://input');
$messageBuilder = new MessageBuilder($xml);
$message = $messageBuilder->build();
$message->autoReply(function () use ($message) {
    if ($message instanceof TextMessage && $message->content == 'hi') {
        return new TextReplyMessage([
            'content' => 'hello',
        ]);
    }
    if ($message instanceof VoiceMessage) {
        if ($message->recognition) {
            return new TextReplyMessage([
                'content' => '语言识别为：' . $message->recognition,
            ]);
        } else {
            return new TextReplyMessage([
                'content' => '语音未识别或未开启语音识别',
            ]);
        }
    }
});