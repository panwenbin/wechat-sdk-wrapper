<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\messages\reply;


use panwenbin\wechat\messages\BaseMessage;

class BaseReplyMessage extends BaseMessage
{
    protected $xmlGroup = [];

    public function toXml()
    {
        $xml = '<xml>';
        $groups = array_unique($this->xmlGroup);
        $groupXMLs = [];
        foreach ($groups as $group) {
            $groupXMLs[$group] = '';
        }
        foreach ($this as $key => $value) {
            if ($key == 'xmlGroup') {
                continue;
            }
            if (isset($this->xmlGroup[$key])) {
                $groupXMLs[$this->xmlGroup[$key]] .= static::buildOneLevelXML($key, $value);
            } else {
                $xml .= static::buildOneLevelXML($key, $value);
            }
        }
        foreach ($groupXMLs as $key => $value) {
            $xml .= static::buildOneLevelXML($key, $value, false);
        }
        $xml .= '</xml>';
        return $xml;
    }

    public static function buildOneLevelXML($key, $value, $cdata = true)
    {
        $key = ucfirst($key);
        if (is_array($value)) {
            $valueStr = '';
            foreach ($value as $_value) {
                $valueStr .= static::buildOneLevelXML('item', $_value);
            }
            return "<{$key}>{$valueStr}</{$key}>";
        }
        if (is_object($value)) {
            $cdata = false;
        }
        if ($cdata) {
            return "<{$key}><![CDATA[{$value}]]></{$key}>";
        } else {
            return "<{$key}>{$value}</{$key}>";
        }
    }
}