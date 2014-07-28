<?php namespace Sseffa\VideoApi;

/**
 * Class YoutubeApi
 * @package Sseffa\VideoApi
 * @author Sefa Karagöz
 */
class YoutubeApi implements VideoApiInterface {

    private $baseChannelUrl = 'http://gdata.youtube.com/feeds/api/videos?q={id}&v=2&alt=jsonc';
    private $baseVideoUrl = 'http://gdata.youtube.com/feeds/api/videos/{id}?v=2&alt=jsonc';
    private $id;

    /**
     * Set id
     * @param $value
     */
    public function setId($value) {

        $this->id = $value;
    }

    /**
     * Get instance
     * @return YoutubeApi
     */
    public static function getInstance() {

        static $instance;

        if (null === $instance) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Get data by url
     * @param $url
     * @return mixed
     * @throws \Exception
     */
    public function getData($url) {

        $url = str_replace('{id}', $this->id, $url);

        $json = @file_get_contents($url);

        if(!$json)
            throw new \Exception("Video or channel id is not found");

        return $this->parseData($json);
    }

    /**
     * Json data parser
     * @param $json
     * @return mixed
     */
    public function parseData($json) {

        $object = json_decode($json);
        return $object;
    }

    /**
     * Get video detail
     * @return array
     */
    public function getVideoDetail() {

        $list = array();
        $data = $this->getData($this->baseVideoUrl);
        $data=$data->data;

        $list['id'] = $data->id;
        $list['title'] = $data->title;
        $list['description'] = $data->description;
        $list['thumbnail'] = $data->thumbnail->sqDefault;
        $list['duration'] = $data->duration;
        $list['likeCount'] = isset($data->likeCount) ? $data->likeCount : 0;
        $list['viewCount'] = isset($data->viewCount) ? $data->viewCount : 0;

        return $list;
    }

    /**
     * Get video channel by id (username)
     * @return array
     */
    public function getVideoList() {

        $list = array();
        $data = $this->getData($this->baseChannelUrl);

        foreach ($data->data->items as $value) {

            $list[$value->id]['id'] = $value->id;
            $list[$value->id]['title'] = $value->title;
            $list[$value->id]['description'] = $value->description;
            $list[$value->id]['thumbnail'] = $value->thumbnail->sqDefault;
            $list[$value->id]['duration'] = $value->duration;
            $list[$value->id]['likeCount'] = isset($value->likeCount) ? $value->likeCount : 0;
            $list[$value->id]['viewCount'] = isset($value->viewCount) ? $value->viewCount : 0;
        }
        return $list;
    }
}
