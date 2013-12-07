<?php
/**
 * WebLabz LLC
 * User: lance
 * Date: 12/6/13
 * Time: 5:43 PM
 */

namespace Weblabz\Scrapyd;


class LogParser {

    //match an error log entry
    private $error_regex = "/^\d{4}-\d{2}-\d{2}((?!ERROR).)*ERROR:((?!\d{4}-\d{2}-\d{2})[\s\S])*/m";
    //match the stats json string at the end of the log
    private $stats_regex = "/(?<=Dumping Scrapy stats:\n\s)\{[^}]*\}/m";
    public function extractErrors($log){
        preg_match_all($this->error_regex, $log, $errors);
        if(is_array($errors) && is_array($errors[0])){
            return $errors[0];
        }else{
            return array();
        }
    }

    public function extractStats($log){
        preg_match($this->stats_regex, $log, $stats);
        if(is_array($stats)){
            return $stats[0];
        }else{
            return "";
        }
    }

    public function extractStatsJson($log){
        $stats = $this->extractStats($log);
        $stats = str_replace(": date", ": \"date", $stats);
        $stats = str_replace(")", ")\"", $stats);
        $stats = str_replace("'", "\"", $stats);
        $stats = json_decode($stats);
        $stats->finish_time = explode(',', str_replace(")", "", str_replace("datetime.datetime(", "", $stats->finish_time)));
        $stats->start_time = explode(',', str_replace(")", "", str_replace("datetime.datetime(", "", $stats->start_time)));
        return $stats;
    }

} 