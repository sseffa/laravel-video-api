<?php namespace Sseffa\VideoApi\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class VideoApi
 * @package Sseffa\Videochannel\Facades
 */
class VideoApi extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {

        return 'video-api';
    }
}