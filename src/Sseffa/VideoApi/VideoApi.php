<?php namespace Sseffa\VideoApi;

use Sseffa\VideoApi\FactoryMethod;

/**
 * Class VideoApi
 * @package Sseffa\VideoApi
 * @author Sefa Karagöz
 */
class VideoApi extends FactoryMethod {

    /**
     * Get video api class instance
     * @param $type
     * @return VimeoApi|YoutubeApi
     * @throws \InvalidArgumentException
     */
    public static function getInstance($type) {

        switch ($type) {

            case parent::YOUTUBE:
                return YoutubeApi::getInstance();
                break;

            case parent::VIMEO:
                return VimeoApi::getInstance();
                break;

            default:
                throw new \InvalidArgumentException("$type is not a valid video site");
        }
    }
}
