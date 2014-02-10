<?php

require_once('modules/jjwg_Maps/controller.php');

/*
 * Custom Controller for jjwg_MapsController
 * location: custom/modules/jjwg_Maps/controller.php
 */
class Customjjwg_MapsController extends jjwg_MapsController
{
    /**
     * Constructor
     */
    function Customjjwg_MapsController() {
        parent::jjwg_MapsController();
    }
    
    /**
     * Custom Override for Defining Maps Address: $aInfo['address']
     * The rest of $aInfo is defined elsewhere in the main controller class
     *
     * @param $aInfo        address info array(address, status, lat, lng)
     * @param $object_name  signular object name
     * @param $display      fetched row array
     */
    function defineMapsAddressCustom($aInfo, $object_name, $display) {
        
        if ($object_name == 'your_Customs') {
            $type = (isset($this->settings['geocode_modules_to_address_type']['your_Customs'])) ? 
                $this->settings['geocode_modules_to_address_type']['your_Customs'] : 
                'billing';
            $GLOBALS['log']->debug(__METHOD__.' $type: '.print_r($type, true));
            
            $aInfo['address'] = $this->bean->defineMapsFormattedAddress($display, $type);
        }
        
        return $aInfo;
    }
    
}

?>