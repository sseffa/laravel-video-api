<?php namespace Sseffa\VideoApi\Services;

/**
 * ServicesInterfaces
 * 
 * @package Sseffa\VideoApi
 * @author  Sefa Karagöz
 */
interface ServicesInterface {

    /**
     * Get Video Data By Url
     * 
     * @param   string  $url
     * @return  mixed
     */
    public function getData($url);

    /**
     * Parse Json To Array
     * 
     * @param   string  $json
     * @return  mixed
     */
    public function parseData($json);

    /**
     * Get Video Detail
     *
     * @param  string   $id
     * @return mixed
     */
    public function getVideoDetail($id);

    /**
     * Get Video List
     * 
     * @param   string  $id
     * @return  mixed
     */
    public function getVideoList($id);
    
}
