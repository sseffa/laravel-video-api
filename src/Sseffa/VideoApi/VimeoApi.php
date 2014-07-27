<?php namespace Sseffa\VideoApi;

use Whoops\Example\Exception;

/**
 * Class VimeoApi
 * @package Sseffa\VideoApi
 * @author Sefa Karagöz
 */
class VimeoApi implements VideoApiInterface {

    private $baseChannelUrl = 'http://vimeo.com/api/v2/{id}/videos.json';
    private $baseVideoUrl = 'http://vimeo.com/api/v2/video/{id}.json"';
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
     * @return VimeoApi
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

        $json = @file_get_contents($url)

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
        $data=$data[0];

        $list[$data->id]['id'] = $data->id;
        $list[$data->id]['title'] = $data->title;
        $list[$data->id]['description'] = $data->description;
        $list[$data->id]['thumbnail'] = $data->thumbnail_small;
        $list[$data->id]['duration'] = $data->duration;
        $list[$data->id]['likeCount'] = isset($data->stats_number_of_likes) ? $data->stats_number_of_likes : 0;
        $list[$data->id]['viewCount'] = isset($data->stats_number_of_plays) ? $data->stats_number_of_plays : 0;

        return $list;
    }

    /**
     * Get video channel by id (username)
     * @return array
     */
    public function getVideoList() {

        $list = array();
        $data = $this->getData($this->baseChannelUrl);

        foreach ($data as $value) {

            $list[$value->id]['id'] = $value->id;
            $list[$value->id]['title'] = $value->title;
            $list[$value->id]['description'] = $value->description;
            $list[$value->id]['thumbnail'] = $value->thumbnail_small;
            $list[$value->id]['duration'] = $value->duration;
            $list[$value->id]['likeCount'] = isset($value->stats_number_of_likes) ? $value->stats_number_of_likes : 0;
            $list[$value->id]['viewCount'] = isset($value->stats_number_of_plays) ? $value->stats_number_of_plays : 0;
        }
        return $list;
    }
}
