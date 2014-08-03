<?php namespace Sseffa\VideoApi;

/**
 * Interface VideoApiInterface
 * @package Sseffa\VideoApi
 * @author Sefa Karagöz
 */
interface VideoApiInterface {

    /**
     * Get video data by url
     * @param $url
     * @return mixed
     */
    public function getData($url);

    /**
     * Parse json to array
     * @param $json
     * @return mixed
     */
    public function parseData($json);

    /**
     * Get video detail
     * @param $id
     * @return mixed
     */
    public function getVideoDetail($id);

    /**
     * Get video list
     * @param $id
     * @return mixed
     */
    public function getVideoList($id);
}
