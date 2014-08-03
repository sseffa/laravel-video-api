<?php namespace Sseffa\VideoApi;

/**
 * Class VideoApi
 * @package Sseffa\VideoApi
 * @author Sefa Karagöz
 */
class VideoApi {

    const YOUTUBE = 'youtube';
    const VIMEO = 'vimeo';

    /**
     * @param $type
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function setType($type) {

        switch ($type) {
            case self::YOUTUBE:
                return new YoutubeApi();
                break;

            case self::VIMEO:
                return new VimeoApi();
                break;

            default:
                throw new \InvalidArgumentException("$type is not a valid video site");
        }
    }
}
