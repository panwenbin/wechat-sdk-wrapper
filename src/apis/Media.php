<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\apis;


use panwenbin\helper\Curl;
use panwenbin\wechat\messages\upload\News;

/**
 * 临时素材上传
 * @package panwenbin\wechat\apis
 */
class Media extends TokenBasedApi
{
    const API_UPLOAD = 'https://api.weixin.qq.com/cgi-bin/media/upload?access_token={ACCESS_TOKEN}&type={TYPE}';
    const API_UPLOAD_IMG = 'https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token={ACCESS_TOKEN}';
    const API_UPLOAD_NEWS = 'https://api.weixin.qq.com/cgi-bin/media/uploadnews?access_token={ACCESS_TOKEN}';
    const API_GET = 'https://api.weixin.qq.com/cgi-bin/media/get?access_token={ACCESS_TOKEN}&media_id={MEDIA_ID}';

    const TYPE_IMAGE = 'image';
    const TYPE_VOICE = 'voice';
    const TYPE_VIDEO = 'video';
    const TYPE_THUMB = 'thumb';

    /**
     * @param $filename
     * @param $type
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     *
     * 正常返回
     * {
     *   "type": "TYPE",
     *   "media_id": "MEDIA_ID",
     *   "created_at": 123456789
     * }
     */
    protected function upload($filename, $type)
    {
        $apiUrl = $this->token->apiUrl(self::API_UPLOAD, ['{TYPE}' => $type]);
        $imageFile = new \CURLFile($filename);
        $response = Curl::to($apiUrl)->withData(['media' => $imageFile])->withOption(CURLOPT_TIMEOUT, 180)->post();
        return $response->jsonBodyArray();
    }

    /**
     * @param $filename
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     */
    public function uploadImage($filename)
    {
        return $this->upload($filename, self::TYPE_IMAGE);
    }

    /**
     * @param $filename
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     */
    public function uploadVoice($filename)
    {
        return $this->upload($filename, self::TYPE_VOICE);
    }

    /**
     * @param $filename
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     */
    public function uploadVideo($filename)
    {
        return $this->upload($filename, self::TYPE_VIDEO);
    }

    /**
     * @param $filename
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     */
    public function uploadThumb($filename)
    {
        return $this->upload($filename, self::TYPE_THUMB);
    }

    /**
     * 上传图文消息内的图片获取URL(群发)
     * @param $filename
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     *
     * 正常返回
     * {
     *   "url":  "http://mmbiz.qpic.cn/mmbiz/gLO17UPS6FS2xsypf378iaNhWacZ1G1UplZYWEYfwvuU6Ont96b1roYs CNFwaRrSaKTPCUdBK9DgEHicsKwWCBRQ/0"
     * }
     */
    public function uploadImg($filename)
    {
        $apiUrl = $this->token->apiUrl(self::API_UPLOAD_IMG);
        $imageFile = new \CURLFile($filename);
        $response = Curl::to($apiUrl)->withData(['media' => $imageFile])->withOption(CURLOPT_TIMEOUT, 180)->post();
        return $response->jsonBodyArray();
    }

    /**
     * @param News $news
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     */
    public function uploadNews(News $news)
    {
        $apiUrl = $this->token->apiUrl(self::API_UPLOAD_NEWS);
        $response = Curl::to($apiUrl)->withData($news->toJson())->post();
        return $response->jsonBodyArray();
    }

    /**
     * 获取临时素材
     * @param string $mediaId
     * @param callable $writeFunction
     * @param bool $isVideo
     * @return bool|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     *
     * writeFunction的签名
     * writeFunction($ch, string $data): int
     * 第一个参数是curl resource，第二个参数是获取的片段，返回值需要是string长度表示写入成功
     * @link http://php.net/manual/en/function.curl-setopt.php
     */
    public function get(string $mediaId, callable $writeFunction, bool $isVideo = false)
    {
        $apiUrl = $this->token->apiUrl(self::API_GET, ['{MEDIA_ID}' => $mediaId]);
        if ($isVideo) {
            $response = Curl::to($apiUrl)->get();
            $jsonArr = $response->jsonBodyArray();
            if (empty($jsonArr['video_url'])) {
                return null;
            }
            $apiUrl = $jsonArr['video_url'];
        }
        Curl::to($apiUrl)->withOption(CURLOPT_WRITEFUNCTION, $writeFunction)->get();
        return true;
    }
}