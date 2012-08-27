<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

require_once('modules/jjwg_Areas/jjwg_Areas_sugar.php');
require_once('modules/jjwg_Maps/jjwg_Maps.php');


class jjwg_Areas extends jjwg_Areas_sugar {

    /**
     * @var settings array
     */
    var $settings = array();

    function jjwg_Areas() {
        
        parent::jjwg_Areas_sugar();
        // Admin Config Setting
        $this->configuration();
    }

    /**
     * Load Configuration Settings using Administration Module
     * See jjwg_Maps module for setting config
     * $GLOBALS['jjwg_config_defaults']
     * $GLOBALS['jjwg_config']
     */
    function configuration() {

        $this->jjwg_Maps = new jjwg_Maps();
        $this->settings = $GLOBALS['jjwg_config'];
    }

    /**
     * 
     * Define polygon coordinates for views
     */
    function define_polygon() {

        $polygon = array();
        if (preg_match('/[\n\r]/', $this->coordinates)) {
            $coords = preg_split("/[\n\r\s]+/", $this->coordinates, null, PREG_SPLIT_NO_EMPTY);
        } else {
            $coords = preg_split("/[\s]+/", $this->coordinates, null, PREG_SPLIT_NO_EMPTY);
        }
        if (count($coords) > 0) {
            foreach ($coords as $coord) {
                $p = preg_split("/[\s\(\)]*,[\s\(\)]*/", $coord, null, PREG_SPLIT_NO_EMPTY);
                if ($this->is_valid_lng($p[0]) && $this->is_valid_lat($p[1])) {
                    $polygon[] = array(
                        'lng' => $p[0],
                        'lat' => $p[1],
                        'elv' => $p[2],
                    );
                }
            }
        }
        if (count($polygon) > 0) {
            return $polygon;
        } else {
            return false;
        }
    }

    /**
     * 
     * Define Area centeral point based on average
     */
    function define_area_loc() {

        $loc = array();
        $i = 0;
        $latTotal = 0.0;
        $lngTotal = 0.0;
        // Find average point (lng,lat,elv)
        $coords = preg_split("/[\n\r]+/", $this->coordinates, null, PREG_SPLIT_NO_EMPTY);
        foreach ($coords as $coord) {
            $p = preg_split("/[\s\(\)]*,[\s\(\)]*/", $coord, null, PREG_SPLIT_NO_EMPTY);
            if ($this->is_valid_lat($p[0]) && $this->is_valid_lng($p[1])) {
                $lngTotal += $p[0];
                $latTotal += $p[1];
                $i++;
            }
        }
        $loc['name'] = $this->name;
        if ($i > 0) {
            $loc['lat'] = $latTotal / floatval($i);
            $loc['lng'] = $lngTotal / floatval($i);
            $loc['elv'] = 0;
        } else {
            $loc['lat'] = 0;
            $loc['lng'] = 0;
            $loc['elv'] = 0;
        }
        $loc = $this->define_loc($loc);

        return $loc;
    }

    /**
     * 
     * Define Marker Location
     * @param $marker mixed (array or object)
     */
    function define_loc($marker = array()) {

        $loc = array();
        if (is_object($marker)) {
            $loc['name'] = $marker->name;
            $loc['lat'] = $marker->jjwg_maps_lat;
            $loc['lng'] = $marker->jjwg_maps_lng;
        } elseif (is_array($marker)) {
            $loc['name'] = $marker['name'];
            $loc['lat'] = $marker['lat'];
            $loc['lng'] = $marker['lng'];
        }
        if (empty($loc['name'])) {
            $loc['name'] = 'N/A';
        }
        if (!$this->is_valid_lat($loc['lat'])) {
            $loc['lat'] = '28.7312';
        }
        if (!$this->is_valid_lng($loc['lng'])) {
            $loc['lng'] = '-81.41267';
        }
        return $loc;
    }

    /**
     * 
     * Check for valid longitude
     * @param $lng float
     */
    function is_valid_lng($lng) {
        return (is_numeric($lng) && $lng >= -180 && $lng <= 180);
    }

    /**
     * 
     * Check for valid latitude
     * @param $lat float
     */
    function is_valid_lat($lat) {
        return (is_numeric($lat) && $lat >= -90 && $lat <= 90);
    }

}
