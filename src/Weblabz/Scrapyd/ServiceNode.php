<?php
/**
 * WebLabz LLC
 * User: lance
 * Date: 8/12/13
 * Time: 11:16 AM
 */

namespace Weblabz\Scrapyd;

class ServiceNode extends Client {

    public function isProjectSupported($project){
        return in_array($this->getProjects()['projects'], $project);
    }
    public function isSpiderSupported($project, $spider){
        return in_array($this->getSpiders($project)['spiders'],$spider);
    }

    public function getSupportedServices(){
       $response = array();
       $projects = $this->getProjects()['projects'];
       if(is_array($projects)){
           foreach($projects as $project){
               $response[$project]=array();
               $spiders = $this->getSpiders($project)['spiders'];
               if(is_array($spiders)){
                   foreach($spiders as $spider){
                       array_push($response[$project], $spider);
                   }
               }
           }
       }
        return $response;
    }
}