<?php namespace Sseffa\VideoApi\Services;

/**
 * Class ServiceTrait
 *
 * @package Sseffa\VideoApi
 * @author  Sefa Karagöz
 */
trait ServiceTrait
{
    /**
     * Set Id
     *
     * @param $value
     */
    public function setId($value)
    {
        $this->id = $value;
    }

    /**
     * Json Data Parser
     *
     * @param   string $json
     * @return  mixed
     * @throws  \Exception
     */
    public function parseData($json)
    {
        $data = json_decode($json);

        if(json_last_error() === JSON_ERROR_NONE)
        {
            return $data;
        }

        throw new \Exception("Video or channel id is not found. (Invalid json)");
    }

    /**
     * Get Video Detail
     *
     * @param   string $url
     * @return  mixed
     * @throws  \Exception
     */
    public function getData($url)
    {
        $json = null;

        if(extension_loaded('curl'))
        {
            $ch = curl_init(str_replace('{id}', $this->id, $url));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $json = curl_exec($ch);
        }
        else
        {
            $json = @file_get_contents(str_replace('{id}', $this->id, $url));
        }

        if(!$json)
        {
            throw new \Exception("Video or channel id is not found");
        }

        return $this->parseData($json);
    }
}
