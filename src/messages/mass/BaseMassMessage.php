<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\messages\mass;


class BaseMassMessage
{
    public $to;
    public $msgtype;

    protected $jsonGroup = [];

    public function toJson()
    {
        $jsonArr = [];
        $groupJSONs = [];
        foreach ($this as $key => $value) {
            if ($key == 'jsonGroup' || $key == 'to') {
                continue;
            }
            if (isset($this->jsonGroup[$key])) {
                $groupJSONs[$this->jsonGroup[$key]][$key] = $value;
            } else {
                $jsonArr[$key] = $value;
            }
        }
        $jsonArr = array_merge($jsonArr, $groupJSONs);
        if (empty($this->to)) {
            $jsonArr['filter'] = [
                'is_to_all' => true,
            ];
        } elseif (is_numeric($this->to)) {
            $jsonArr['filter'] = [
                'is_to_all' => false,
                'tag_id' => (int)$this->to,
            ];
        } elseif (is_array($this->to)) {
            $jsonArr['touser'] = $this->to;
        }
        return json_encode($jsonArr);
    }
}