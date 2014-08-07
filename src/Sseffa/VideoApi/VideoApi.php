<?php namespace Sseffa\VideoApi;

/**
 * Class VideoApi
 *
 * @package Sseffa\VideoApi
 * @author  Sefa Karagöz
 */
class VideoApi {

    /**
     * Youtube
     *
     * @var Const
     */
    const YOUTUBE = 'youtube';

    /**
     * Vimeo
     *
     * @var Const
     */
    const VIMEO = 'vimeo';

    /**
     * Set Type
     * 
     * @param   string  $type
     * @return  mixed
     * @throws  \InvalidArgumentException
     */
    public function setType($type) 
    {

        switch ($type) {
            case self::YOUTUBE:
                return new Services\Youtube();
                break;

            case self::VIMEO:
                return new Services\Vimeo();
                break;

            default:
                throw new \InvalidArgumentException("$type is not a valid video site");
        }
    }
    
}
