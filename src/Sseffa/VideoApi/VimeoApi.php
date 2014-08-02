<?php namespace Sseffa\VideoApi;

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
        $data = $data[0];

        return array(
            'id'               => $data->id,
            'title'            => $data->title,
            'description'      => $data->description,
            'thumbnail_small'  => $data->thumbnail_small,
            'thumbnail_large'  => $data->thumbnail_large,
            'duration'         => $data->duration,
            'upload_date'      => $data->upload_date,
            'likeCount'        => isset($data->stats_number_of_likes) ? $data->stats_number_of_likes : 0,
            'viewCount'        => isset($data->stats_number_of_plays) ? $data->stats_number_of_plays : 0,
            'commentCount'     => isset($data->stats_number_of_comments) ? $data->stats_number_of_comments : 0
        );
    }

    /**
     * Get video channel by id (username)
     * @return array
     */
    public function getVideoList() {

        $list = array();
        $data = $this->getData($this->baseChannelUrl);

        foreach ($data as $value) {
            $list[$value->id] = array(
                'id'          => $value->id,
                'title'       => $value->title,
                'description' => $value->description,
                'thumbnail'   => $value->thumbnail->sqDefault,
                'duration'    => $value->duration,
                'likeCount'   => isset($value->stats_number_of_likes) ? $value->stats_number_of_likes : 0,
                'viewCount'   => isset($value->stats_number_of_plays) ? $value->stats_number_of_plays : 0
            );
        }
        return $list;
    }
}
