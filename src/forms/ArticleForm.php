<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\forms;

use panwenbin\wechat\apis\Media;
use panwenbin\wechat\exceptions\BadFormFormatException;
use panwenbin\wechat\exceptions\UploadFailedException;
use panwenbin\wechat\messages\upload\Article as UploadArticle;


/**
 * 只给News使用
 * @package panwenbin\wechat\forms
 */
class ArticleForm
{
    public $thumb_url; // 64KB JPG
    public $author;
    public $title;
    public $content_source_url;
    public $content;
    public $digest;
    public $show_cover_pic = 1;

    protected $tmpThumbFilename;

    /**
     * @throws BadFormFormatException
     */
    protected function validate()
    {
        if (substr($this->thumb_url, -4) != '.jpg') {
            throw new BadFormFormatException('thumb_url只支持jpg格式');
        }
        $this->tmpThumbFilename = tempnam(sys_get_temp_dir(), 'wx_thumb_');
        rename($this->tmpThumbFilename, $this->tmpThumbFilename . '.jpg');
        $this->tmpThumbFilename = $this->tmpThumbFilename . '.jpg';
        file_put_contents($this->tmpThumbFilename, file_get_contents($this->thumb_url));
        if (filesize($this->tmpThumbFilename) > 64 * 1024) {
            throw new BadFormFormatException('thumb_url文件大小最大64KB');
        }
    }

    /**
     * @param Media $media
     * @return UploadArticle
     * @throws UploadFailedException
     * @throws \panwenbin\wechat\exceptions\WechatException
     */
    public function toUploadArticle(Media $media): UploadArticle
    {
        $this->validate();
        $response = $media->uploadThumb($this->tmpThumbFilename);
        unlink($this->tmpThumbFilename);
        if (!isset($response['type'], $response['thumb_media_id'])) {
            $errcode = $response['errcode'] ?? 0;
            $errmsg = $response['errmsg'] ?? '';
            throw new UploadFailedException("缩略图上传失败 errcode: {$errcode} errmsg: {$errmsg}");
        }
        $thumbMediaId = $response['thumb_media_id'];
        $imgReplaceMap = [];
        if (preg_match_all('/<img [^>]*src=["\']?([^"\'\s]+)["\']?/', $this->content, $matches)) {
            foreach ($matches[1] as $imgSrc) {
                $pathinfo = pathinfo($imgSrc);
                $ext = $pathinfo['extension'] ?? 'jpg';
                $tmpFilename = tempnam(sys_get_temp_dir(), 'wx_img_');
                rename($tmpFilename, $tmpFilename . '.' . $ext);
                $tmpFilename = $tmpFilename . '.' . $ext;
                file_put_contents($tmpFilename, file_get_contents($imgSrc));
                $response = $media->uploadImg($tmpFilename);
                unlink($tmpFilename);
                if (!isset($response['url'])) {
                    $errcode = $response['errcode'] ?? 0;
                    $errmsg = $response['errmsg'] ?? '';
                    throw new UploadFailedException("图片上传失败 errcode: {$errcode} errmsg: {$errmsg}");
                }
                $imgReplaceMap[$imgSrc] = $response['url'];
            }
        }
        $uploadArticle = new UploadArticle();
        $uploadArticle->thumb_media_id = $thumbMediaId;
        $uploadArticle->author = $this->author;
        $uploadArticle->title = $this->title;
        $uploadArticle->content_source_url = $this->content_source_url;
        $uploadArticle->content = strtr($this->content, $imgReplaceMap);
        $uploadArticle->show_cover_pic = $this->show_cover_pic;
        return $uploadArticle;
    }
}