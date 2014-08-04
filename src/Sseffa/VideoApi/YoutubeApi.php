<?php namespace Sseffa\VideoApi;

/**
 * Class YoutubeApi
 * @package Sseffa\VideoApi
 * @author Sefa Karagöz
 */
class YoutubeApi implements VideoApiInterface {

    use VideoApiTrait;

    private $baseChannelUrl = 'http://gdata.youtube.com/feeds/api/videos?q={id}&v=2&alt=jsonc';
    private $baseVideoUrl = 'http://gdata.youtube.com/feeds/api/videos/{id}?v=2&alt=jsonc';
    private $id;

    /**
     * Get video detail
     * @param $id
     * @return array|mixed
     * @throws \Exception
     */
    public function getVideoDetail($id) {

        $this->setId($id);

        $data = $this->getData($this->baseVideoUrl);

        if(isset($data->error))
            throw new \Exception("Video not found");

        $data = $data->data;

        return array(
            'id'              => $data->id,
            'title'           => $data->title,
            'description'     => $data->description,
            'thumbnail_small' => $data->thumbnail->sqDefault,
            'thumbnail_large' => $data->thumbnail->hqDefault,
            'duration'        => $data->duration,
            'upload_date'     => $data->uploaded,
            'like_count'      => isset($data->likeCount) ? $data->likeCount : 0,
            'view_count'      => isset($data->viewCount) ? $data->viewCount : 0,
            'comment_count'   => isset($data->commentCount) ? $data->commentCount : 0
        );
    }

    /**
     * Get video channel by id (username)
     * @param $id
     * @return array|mixed
     * @throws \Exception
     */
    public function getVideoList($id) {

        $this->setId($id);

        $list = array();
        $data = $this->getData($this->baseChannelUrl);

        if(!isset($data->data->items))
            throw new \Exception("Video channel not found");

        foreach ($data->data->items as $value) {
            $list[$value->id] = array(
                'id'              => $value->id,
                'title'           => $value->title,
                'description'     => $value->description,
                'thumbnail_small' => $value->thumbnail->sqDefault,
                'thumbnail_large' => $value->thumbnail->hqDefault,
                'duration'        => $value->duration,
                'upload_date'     => $value->uploaded,
                'like_count'      => isset($value->likeCount) ? $value->likeCount : 0,
                'view_count'      => isset($value->viewCount) ? $value->viewCount : 0,
                'comment_count'   => isset($value->commentCount) ? $value->commentCount : 0
            );
        }
        return $list;
    }
}
