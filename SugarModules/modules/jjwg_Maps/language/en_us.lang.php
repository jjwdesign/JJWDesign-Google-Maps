<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$mod_strings = array(
  'LBL_MAP' => 'Map',
  'LBL_MAPS' => 'Maps',
  'LBL_MODULE_NAME' => 'Maps',
  'LBL_MODULE_TITLE' => 'Maps: Home',
  'LBL_MODULE_ID'=> 'Maps',
  'LBL_LIST_FORM_TITLE' => 'Maps Listing',
  'LBL_HOMEPAGE_TITLE' => 'Maps Listing',

  'LBL_FLEX_RELATE' => 'Related to (Center):',
  'LBL_MODULE_TYPE' => 'Module Type to Display:',
  'LBL_DISTANCE' => 'Distance (Radius):',
  'LBL_UNIT_TYPE' => 'Unit Type:',

  'LBL_MAP_ACTION' => 'Map It',
  'LBL_MAP_DISPLAY' => 'Map Display',
  'LBL_MAP_LEGEND' => 'Legend:',
  'LBL_MAP_USERS' => 'Users:',
  'LBL_MAP_USER_GROUPS' => 'Groups:',
  'LBL_MAP_ASSIGNED_TO' => 'Assigned to:',

  'LNK_NEW_MAP' => 'Add New Map',
  'LNK_NEW_RECORD' => 'Add New Map',
  'LNK_MAP_LIST' => 'List Maps',
  'LNK_IMPORT_MAPS' => 'Import Maps',
  'LBL_MAP_GEOCODE_ADDRESSES' => 'Geocode Addresses',
  'LBL_MAP_DONATE' => 'Donate',
  'LBL_MAP_DONATE_TO_THIS_PROJECT' => 'Donate to this Project',
  'LBL_BUG_FIX' => 'Bug Fix',

  'LBL_MAP_ADDRESS_TEST' => 'Geocoding Test',
  'LBL_MAP_ADDRESS' => 'Address',
  'LBL_MAP_PROCESS' => 'Process It!',

  'LBL_MAP_LAST_STATUS' => 'Last Geocode Status',
  'LBL_MAP_GEOCODED_COUNTS' => 'Geocoded Counts',
  'LBL_GEOCODED_COUNTS' => 'Module Geocoded Counts',
  'LBL_CRON_URL' => 'Cron URL:',
  'LBL_MODULE_HEADING' => 'Module',
  'LBL_MODULE_TOTAL_HEADING' => 'Total',
  'LBL_GEOCODED_COUNTS_DESCRIPTION' => 'The table shown belown shows the number of module objects geocoded, grouped by geocoding response. '. 
    'Keep in mind that the standard Google Maps usage limit is 2500 requests per day. '.
    'This module will cache the addresses geocoding information during processing to reduce the overall number of requests needed.',
  'LBL_CRON_INSTRUCTIONS' => 'To process the geocoding requests it is recommended to setup a nightly Cron-Job. '.
    'A custom entry point has been created for this purpose and can be accessed without authentication. '.
    'The URL shown below is meant to be used with an Administrative Scheduled Task. '.
    'Please see the SugarCRM documentation for more information.',

);

?>
