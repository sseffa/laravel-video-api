<?php namespace Sseffa\VideoApi;

/**
 * Class FactoryMethod
 * @package Sseffa\VideoApi
 * @author Sefa Karagöz
 */
abstract class FactoryMethod {

    const YOUTUBE = 1;
    const VIMEO = 2;

    abstract public function getInstance($type);
}
