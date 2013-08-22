<?php
/**
 * WebLabz LLC
 * User: lance
 * Date: 8/8/13
 * Time: 5:20 PM
 */

namespace Weblabz\Scrapyd;

use Net_Http_Client as NET;
use Net_HTTp_Exception;


class Client{

    public $base_url, $protocol, $port, $http_client;

    public function __construct($base_url="localhost", $protocol="http",$port=80){
        $this->base_url = $base_url;
        $this->port = $port;
        $this->protocol = $protocol;
        $this->http_client = new NET;
    }

    public function buildServiceUrl($service){

        $url = $this->protocol."://".$this->base_url.($this->port==80?'':':'.$this->port).'/'.$service;
        return $url;
    }

    public function getJsonResponse(){
        return json_decode($this->http_client->getBody(), true);
    }
    public function getErrorResponse($exception){
        return array(
            'status'=>'error',
            'message'=>$exception->getMessage()
        );
    }

    /**
     * @return array (
     *      'projects'=> ['project1', 'project2']
     * )
     */
    public function getProjects(){
        try{
            $this->http_client->get($this->buildServiceUrl('listprojects.json'));
        }catch(Net_Http_Exception $e){
            return $this->getErrorResponse($e);
        }
        return $this->getJsonResponse();
    }

    /**
     * @param $project name of a project in the scrapyd service
     * @return array|mixed
     */
    public function getSpiders($project){
        try{
            $data = array(
                'project'=>$project
            );
            $this->http_client->get($this->buildServiceUrl('listspiders.json'), $data);
        }catch(Net_Http_Exception $e){
            return $this->getErrorResponse($e);
        }
        return $this->getJsonResponse();
    }

    /**
     * @param $project name of a project in the scrapyd service
     * @return array|mixed
     */
    public function getProjectVersions($project){
        try{
            $data = array(
                'project'=>$project
            );
            $this->http_client->get($this->buildServiceUrl('listversions.json'), $data);
        }catch(Net_Http_Exception $e){
            return $this->getErrorResponse($e);
        }
        return $this->getJsonResponse();

    }

    /**
     * Wrapper for the scrapyd addversion.json API call
     * creates a project if it doesn't exist, adds a new version if it does.
     *
     * note: when scheduling a spider, it uses the latest project version
     *
     * @param $project name of a project in the scrapyd service
     * @param $version version that will identify the egg being uploaded
     * @param $egg a python egg that contains scrapy spiders - created in a scrapy project by running 'python setup.ph bdist_egg' in the project root dir
     *             The egg will be in the dist folder
     * @return array(
     *
     * )
     */
    public function saveProject($project, $version, $egg){
        try{
            $data = array(
                'project'=>$project,
                'version'=>$version,
                'egg'=>'@'.$egg
            );
            $this->http_client->post($this->buildServiceUrl('addversion.json'), $data);
        }catch(Net_Http_Exception $e){
            return $this->getErrorResponse($e);
        }
        return $this->getJsonResponse();

    }

    public function scheduleJob($project, $spider,$params){
        try{
            $params['project']=$project;
            $params['spider']=$spider;
            $this->http_client->post($this->buildServiceUrl('schedule.json'), $params);
        }catch(Net_Http_Exception $e){
            return $this->getErrorResponse($e);
        }
        return $this->getJsonResponse();
    }
    public function getJobs($project){
        try{
            $data = array(
                'project'=>$project
            );
           $this->http_client->get($this->buildServiceUrl('listjobs.json'), $data);
        }catch(Net_Http_Exception $e){
            return $this->getErrorResponse($e);
        }
        return $this->getJsonResponse();

    }
    public function cancelJob($project, $job){
        try{
            $data = array(
                'project'=>$project,
                'job'=>$job
            );
            $this->http_client->post($this->buildServiceUrl('cancel.json'), $data);
        }catch(Net_Http_Exception $e){
            return $this->getErrorResponse($e);
        }
        return $this->getJsonResponse();

    }

    public function deleteProjectVersion($project, $version){
        try{
            $data = array(
                'project'=>$project,
                'version'=>$version
            );
            $this->http_client->post($this->buildServiceUrl('delversion.json'), $data);
        }catch(Net_Http_Exception $e){
            return $this->getErrorResponse($e);
        }
        return $this->getJsonResponse();

    }

    public function deleteProject($project){
        try{
            $data = array(
                'project'=>$project,
            );
            $this->http_client->post($this->buildServiceUrl('delproject.json'), $data);
        }catch(Net_Http_Exception $e){
            return $this->getErrorResponse($e);
        }
        return $this->getJsonResponse();

    }

}