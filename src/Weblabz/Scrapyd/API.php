<?php namespace  Weblabz\Scrapyd;

class API{

    private $cluster = array();

    public function registerDaemon(ServiceNode $service){
        array_push($cluster, $service);
    }

}