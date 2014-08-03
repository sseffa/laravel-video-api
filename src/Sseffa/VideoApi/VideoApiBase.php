<?php namespace Sseffa\VideoApi;

/**
 * Class VideoApiBase
 * @package Sseffa\VideoApi
 * @author Sefa Karagöz
 */
trait VideoApiBase {

    /**
     * Set id
     * @param $value
     */
    public function setId($value) {

        $this->id = $value;
    }

    /**
     * Json data parser
     * @param $json
     * @return mixed
     */
    public function parseData($json) {

        return json_decode($json);
    }

    /**
     * Get video detail
     * @param $url
     * @return mixed
     * @throws \Exception
     */
    public function getData($url) {

        $json = @file_get_contents(str_replace('{id}', $this->id, $url));

        if (!$json)
            throw new \Exception("Video or channel id is not found");

        return $this->parseData($json);
    }
}