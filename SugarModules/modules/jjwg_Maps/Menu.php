<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 

global $mod_strings, $app_strings, $sugar_config;

if(ACLController::checkAccess('jjwg_Maps', 'edit', true))$module_menu[]=Array("index.php?module=jjwg_Maps&action=EditView&return_module=jjwg_Maps&return_action=index", $mod_strings['LNK_NEW_MAP'], "Createjjwg_Maps", 'jjwg_Maps');

if(ACLController::checkAccess('jjwg_Maps', 'list', true))$module_menu[]=Array("index.php?module=jjwg_Maps&action=index&return_module=jjwg_Maps&return_action=DetailView", $mod_strings['LNK_MAP_LIST'], "jjwg_Maps", 'jjwg_Maps');

if(ACLController::checkAccess('jjwg_Maps', 'import', true))$module_menu[]=Array("index.php?module=Import&action=Step1&import_module=jjwg_Maps&return_module=jjwg_Maps&return_action=index", $mod_strings['LNK_IMPORT_MAPS'], "Importjjwg_Maps", 'jjwg_Maps');

if(ACLController::checkAccess('jjwg_Maps', 'geocoded_counts', true))$module_menu[]=Array("index.php?module=jjwg_Maps&action=geocoded_counts&return_module=jjwg_Maps&return_action=index", $mod_strings['LBL_MAP_GEOCODED_COUNTS'], "jjwg_Maps", 'jjwg_Maps');

if(ACLController::checkAccess('jjwg_Maps', 'geocoding_test', true))$module_menu[]=Array("index.php?module=jjwg_Maps&action=geocoding_test&return_module=jjwg_Maps&return_action=index", $mod_strings['LBL_MAP_ADDRESS_TEST'], "jjwg_Maps", 'jjwg_Maps');

if(ACLController::checkAccess('jjwg_Maps', 'geocode_addresses', true))$module_menu[]=Array("index.php?module=jjwg_Maps&action=geocode_addresses&return_module=jjwg_Maps&return_action=index", $mod_strings['LBL_MAP_GEOCODE_ADDRESSES'], "jjwg_Maps", 'jjwg_Maps');

if(ACLController::checkAccess('jjwg_Maps', 'donate', true))$module_menu[]=Array("index.php?module=jjwg_Maps&action=donate&return_module=jjwg_Maps&return_action=index", $mod_strings['LBL_MAP_DONATE_TO_THIS_PROJECT'], "jjwg_Maps", 'jjwg_Maps');

?>
