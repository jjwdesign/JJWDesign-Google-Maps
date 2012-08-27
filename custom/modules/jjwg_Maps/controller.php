<?php

require_once('modules/jjwg_Maps/controller.php');

/*
 * Custom Controller for jjwg_MapsController
 * location: custom/modules/jjwg_Maps/controller.php
 */

class Customjjwg_MapsController extends jjwg_MapsController {

    function __construct() {

        parent::__construct();
        /**
         * This settings section is now deprecated!
         * Modify settings using Config Page user interface or 'config' table.
         * 
         * Load Configuration Settings using Administration Module
         * See jjwg_Maps module for setting config
         * $GLOBALS['jjwg_config_defaults']
         * $GLOBALS['jjwg_config']
         * 
         */
    }

}

