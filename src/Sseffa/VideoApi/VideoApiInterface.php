<?php namespace Sseffa\VideoApi;

/**
 * Interface VideoApiInterface
 * @package Sseffa\VideoApi
 * @author Sefa Karagöz
 */
interface VideoApiInterface {

    public function getData($url);

    public function parseData($json);

    public function getVideoDetail();

    public function getVideoList();
}
