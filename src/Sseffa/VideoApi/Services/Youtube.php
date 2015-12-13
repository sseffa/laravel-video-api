<?php namespace Sseffa\VideoApi\Services;

/**
 * Youtube
 *
 * @package Sseffa\VideoApi
 * @author  Sefa Karagöz
 */
class Youtube implements ServicesInterface
{
    use ServiceTrait;
    /**
     * Base Channel Url
     *
     * @var String
     */
    private $baseChannelUrl = 'https://www.googleapis.com/youtube/v3/playlistItems?part=contentDetails&playlistId={id}&key={key}';
    /**
     * Base Video Url
     *
     * @var String
     */
    private $baseVideoUrl = 'https://www.googleapis.com/youtube/v3/videos?id={id}&key={key}&part=snippet,contentDetails,statistics';
    /**
     * Id
     *
     * @var String
     */
    private $id;
    protected $key;

    public function setKey($value)
    {
        $this->key = $value;

        return $this;
    }

    /**
     * Get Video Detail
     * @param string $id
     * @return array
     * @throws \Exception
     */
    public function getVideoDetail($id)
    {
        $this->setId($id);

        $data = $this->getData(str_replace('{key}', $this->key, $this->baseVideoUrl));

        if(isset($data->error))
        {
            throw new \Exception("Video not found");
        }

        return array(
            'id'              => $data->items[0]->id,
            'title'           => $data->items[0]->snippet->title,
            'description'     => $data->items[0]->snippet->description,
            'thumbnail_small' => $data->items[0]->snippet->thumbnails->default->url,
            'thumbnail_large' => $data->items[0]->snippet->thumbnails->high->url,
            'duration'        => $data->items[0]->contentDetails->duration,
            'upload_date'     => $data->items[0]->snippet->publishedAt,
            'like_count'      => isset($data->items[0]->statistics->likeCount) ? $data->items[0]->statistics->likeCount : 0,
            'view_count'      => isset($data->items[0]->statistics->viewCount) ? $data->items[0]->statistics->viewCount : 0,
            'comment_count'   => isset($data->items[0]->statistics->commentCount) ? $data->items[0]->statistics->commentCount : 0,
            'uploader'        => null
        );
    }

    /**
     * Get Video List
     * @param string $id
     * @return array
     * @throws \Exception
     */
    public function getVideoList($id)
    {
        $this->setId($id);

        $list = array();
        $data = $this->getData(str_replace('{key}', $this->key, $this->baseChannelUrl));

        if(!isset($data->items))
        {
            throw new \Exception("Video channel not found");
        }

        foreach($data->items as $value)
        {
            $list[] = $this->getVideoDetail($value->contentDetails->videoId);
        }

        return $list;
    }
}
