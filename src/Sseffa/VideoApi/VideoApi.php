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
     * Get video api class instance
     * @param $type
     * @return VimeoApi|YoutubeApi
     * @throws \InvalidArgumentException
     */
    public static function getInstance($type) {

        switch ($type) {
            case self::YOUTUBE:
                return YoutubeApi::getInstance();
                break;

            case self::VIMEO:
                return VimeoApi::getInstance();
                break;

            default:
                throw new \InvalidArgumentException("$type is not a valid video site");
        }
    }
}
