<?php namespace Sseffa\VideoApi\Services;

use DateTimeImmutable;
use DateInterval;

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
            'duration'        => static::_convert_time($data->items[0]->contentDetails->duration),
            'upload_date'     => $data->items[0]->snippet->publishedAt,
            'like_count'      => isset($data->items[0]->statistics->likeCount) ? $data->items[0]->statistics->likeCount : 0,
            'view_count'      => isset($data->items[0]->statistics->viewCount) ? $data->items[0]->statistics->viewCount : 0,
            'comment_count'   => isset($data->items[0]->statistics->commentCount) ? $data->items[0]->statistics->commentCount : 0,
            'uploader'        => $data->items[0]->snippet->channelTitle
        );
    }

    /**
     * Get Video Raw Data
     * @param string $id
     * @return array
     * @throws \Exception
     */
    public function getVideoRawData($id)
    {
        $this->setId($id);

        $data = $this->getData(str_replace('{key}', $this->key, $this->baseVideoUrl));

        if(isset($data->error))
        {
            throw new \Exception("Video not found");
        }

        return $data;
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

    /**
     * Parse a youtube URL to get the youtube Vid.
     * Support both full URL (www.youtube.com) and short URL (youtu.be)
     * Source: https://github.com/alaouy/Youtube
     *
     * @param  string $youtube_url
     * @throws \Exception
     * @return string Video Id
     */
    public function parseVIdFromURL($youtube_url)
    {
        if (strpos($youtube_url, 'youtube.com')) {
            if (strpos($youtube_url, 'embed')) {
                $path = static::_parse_url_path($youtube_url);
                $vid = substr($path, 7);
                return $vid;
            } else {
                $params = static::_parse_url_query($youtube_url);
                return $params['v'];
            }
        } else if (strpos($youtube_url, 'youtu.be')) {
            $path = static::_parse_url_path($youtube_url);
            $vid = substr($path, 1);
            return $vid;
        } else {
            throw new \Exception('The supplied URL does not look like a Youtube URL');
        }
    }

    /**
     * Parse the input url string and return just the path part
     * Source: https://github.com/alaouy/Youtube
     *
     * @param  string $url the URL
     * @return string      the path string
     */
    public static function _parse_url_path($url)
    {
        $array = parse_url($url);

        return $array['path'];
    }

    /**
     * Parse the input url string and return an array of query params
     * Source: https://github.com/alaouy/Youtube
     *
     * @param  string $url the URL
     * @return array      array of query params
     */
    public static function _parse_url_query($url)
    {
        $array = parse_url($url);
        $query = $array['query'];

        $queryParts = explode('&', $query);

        $params = array();
        foreach ($queryParts as $param) {
            $item = explode('=', $param);
            $params[$item[0]] = empty($item[1]) ? '' : $item[1];
        }

        return $params;
    }

    /**
     * Parse the YouTube timestamp to seconds
     * @param  string $time YouTube format timestamp
     * @return integer      Seconds
     */
    public static function _convert_time($time)
    {
        $reference = new DateTimeImmutable;
        $endTime = $reference->add(new DateInterval($time));

        return $endTime->getTimestamp() - $reference->getTimestamp();
    }
}
