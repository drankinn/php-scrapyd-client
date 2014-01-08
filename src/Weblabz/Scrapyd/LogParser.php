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

    private $date_index = [
        'year'=>0,
        'month'=>1,
        'day'=>2,
        'hour'=>3,
        'minute'=>4,
        'second'=>5
    ];
    private $date_format = "Y-m-d H:i:s";

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
        if(is_array($stats) && sizeof($stats)>0){
            return $stats[0];
        }else{
            return "";
        }
    }

    public function extractStatsJson($log){
        $stats = $this->extractStats($log);
        if(isset($stats) && "" != $stats){
            $stats = str_replace(": date", ": \"date", $stats);
            $stats = str_replace(")", ")\"", $stats);
            $stats = str_replace("'", "\"", $stats);
            $stats = json_decode($stats);
            $stats->finish_time = $this->getStatsDate(explode(',', str_replace(")", "", str_replace("datetime.datetime(", "", $stats->finish_time))));
            $stats->start_time = $this->getStatsDate(explode(',', str_replace(")", "", str_replace("datetime.datetime(", "", $stats->start_time))));
        }
        return $stats;
    }

    public function getStatsDate($date_array){
        $date_string = $date_array[$this->date_index['year']] . '-' . $date_array[$this->date_index['month']] . '-'
            . $date_array[$this->date_index['day']] . ' ' . $date_array[$this->date_index['hour']] . ":"
            . $date_array[$this->date_index['minute']] . ':' . $date_array[$this->date_index['second']];
        $date_string = str_replace(" ", "", $date_string);
        $start_date = new \DateTime($date_string, new \DateTimeZone("UTC"));
        return $start_date->format($this->date_format);
    }

} 