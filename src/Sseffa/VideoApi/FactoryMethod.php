<?php namespace Sseffa\VideoApi;

/**
 * Class FactoryMethod
 * @package Sseffa\VideoApi
 * @author Sefa Karagöz
 */
abstract class FactoryMethod {

    const YOUTUBE = 'youtube';
    const VIMEO = 'vimeo';

    abstract public function getInstance($type);
}
