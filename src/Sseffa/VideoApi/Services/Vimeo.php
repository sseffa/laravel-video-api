<?php namespace Sseffa\VideoApi\Services;

/**
 * Vimeo
 *
 * @package Sseffa\VideoApi
 * @author  Sefa Karagöz
 */
class Vimeo implements ServicesInterface {

    use ServiceTrait;

    /**
     * Base Channel Url
     *
     * @var String
     */
    private $baseChannelUrl = 'http://vimeo.com/api/v2/{id}/videos.json';

    /**
     * Base Video Url
     *
     * @var String
     */
    private $baseVideoUrl = 'http://vimeo.com/api/v2/video/{id}.json';

    /**
     * Id
     *
     * @var String
     */
    private $id;

    /**
     * Get Video Detail
     *
     * @param   string $id
     * @return  array|mixed
     * @throws  \Exception
     */
    public function getVideoDetail($id)
    {
        $this->setId($id);

        $data = $this->getData($this->baseVideoUrl);

        if(!$data) {
            throw new \Exception("Video not found");
        }

        $data = $data[0];

        return array(
            'id'              => $data->id,
            'title'           => $data->title,
            'description'     => $data->description,
            'thumbnail_small' => $data->thumbnail_small,
            'thumbnail_large' => $data->thumbnail_large,
            'duration'        => $data->duration,
            'upload_date'     => $data->upload_date,
            'like_count'      => isset($data->stats_number_of_likes) ? $data->stats_number_of_likes : 0,
            'view_count'      => isset($data->stats_number_of_plays) ? $data->stats_number_of_plays : 0,
            'comment_count'   => isset($data->stats_number_of_comments) ? $data->stats_number_of_comments : 0,
            'uploader'        => $data->user_name
        );
    }

    /**
     * Get Video Raw Data
     *
     * @param   string $id
     * @return  array|mixed
     * @throws  \Exception
     */
    public function getVideoRawData($id)
    {
        $this->setId($id);

        $data = $this->getData($this->baseVideoUrl);

        if(!$data) {
            throw new \Exception("Video not found");
        }

        $data = $data[0];

        return $data;
    }

    /**
     * Get Video Channel By Id (username)
     *
     * @param   string  $id
     * @return  array|mixed
     * @throws  \Exception
     */
    public function getVideoList($id)
    {

        $this->setId($id);

        $list = array();
        $data = $this->getData($this->baseChannelUrl);

        if(!$data) {
            throw new \Exception("Video channel not found");
        }

        foreach ($data as $value) {
            $list[$value->id] = array(
                'id'              => $value->id,
                'title'           => $value->title,
                'description'     => $value->description,
                'thumbnail_small' => $value->thumbnail_small,
                'thumbnail_large' => $value->thumbnail_large,
                'duration'        => $value->duration,
                'upload_date'     => $value->upload_date,
                'like_count'      => isset($value->stats_number_of_likes) ? $value->stats_number_of_likes : 0,
                'view_count'      => isset($value->stats_number_of_plays) ? $value->stats_number_of_plays : 0,
                'comment_count'   => isset($value->stats_number_of_comments) ? $value->stats_number_of_comments : 0
            );
        }
        return $list;
    }

    /**
     * Parse a vimeo URL to get the vimeo video id.
     * Support vimeo.com url
     *
     * @param  string $vimeo_url
     * @throws \Exception
     * @return string Video Id
     */
    public function parseVIdFromURL($vimeo_url)
    {
        if (strpos($vimeo_url, 'vimeo.com')) {
            $tokens = explode("/", $vimeo_url);
            if(is_numeric($tokens[3]))
                return $tokens[3];
            else
                throw new \Exception('The supplied URL does not contain a valid Vimeo video id');
        } else {
            throw new \Exception('The supplied URL does not look like a Vimeo URL');
        }
    }
}

