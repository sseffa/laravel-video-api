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

        if ($instance === null) {
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

        $json = @file_get_contents(str_replace('{id}', $this->id, $url));

        if (!$json)
            throw new \Exception("Video or channel id is not found");

        return $this->parseData($json);
    }

    /**
     * Json data parser
     * @param $json
     * @return mixed
     */
    public function parseData($json) {

        return json_decode($json);
    }

    /**
     * Get video detail
     * @return array
     */
    public function getVideoDetail() {

        $data = $this->getData($this->baseVideoUrl);
        $data = $data->data;

        return array(
            'id'              => $data->id,
            'title'           => $data->title,
            'description'     => $data->description,
            'thumbnail_small' => $data->thumbnail->sqDefault,
            'thumbnail_large' => $data->thumbnail->hqDefault,
            'duration'        => $data->duration,
            'uploaded'        => $data->uploaded,
            'likeCount'       => isset($data->likeCount) ? $data->likeCount : 0,
            'viewCount'       => isset($data->viewCount) ? $data->viewCount : 0,
            'commentCount'    => isset($data->commentCount) ? $data->commentCount : 0
        );
    }

    /**
     * Get video channel by id (username)
     * @return array
     */
    public function getVideoList() {

        $list = array();
        $data = $this->getData($this->baseChannelUrl);

        foreach ($data->data->items as $value) {
            $list[$value->id] = array(
                'id'          => $value->id,
                'title'       => $value->title,
                'description' => $value->description,
                'thumbnail'   => $value->thumbnail->sqDefault,
                'duration'    => $value->duration,
                'likeCount'   => isset($value->likeCount) ? $value->likeCount : 0,
                'viewCount'   => isset($value->viewCount) ? $value->viewCount : 0
            );
        }
        return $list;
    }
}
