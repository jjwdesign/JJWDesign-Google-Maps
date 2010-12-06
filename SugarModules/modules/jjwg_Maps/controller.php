<?php
// modules/jjwg_Maps/controller.php

require_once('include/utils.php');
require_once('include/export_utils.php');
require_once('include/JSON.php');
require_once("include/Sugar_Smarty.php");

class jjwg_MapsController extends SugarController {
  
  /**
   * geocode_cache array is used to store current geocoded information during processing
   * @var array
   */
  var $geocode_cache = array();
  
  /**
   * @var valid_geocode_modules defined the valid module names used with geocoding
   */
  var $valid_geocode_modules = array('Accounts','Contacts','Leads','Opportunities','Cases','Project');
  
  /**
   * $geocoding_limit sets the query limit when selecting records to geocode
   * @var integer
   */
  var $geocoding_limit = 2500;
  
  /**
   * $google_geocoding_limit sets the request limit when geocoding using the Google Maps API
   * @var integer
   */
  var $google_geocoding_limit = 250;
  
  /**
   * $map_markers_limit sets the query limit when selecting records to display on a map
   * @var integer
   */
  var $map_markers_limit = 1000;
  
  /**
   * $map_default_unit_type sets the default unit measurement type for distance calculations
   * @var string
   * Values: 'mi' (miles) or 'km' (kilometers)
   */
  var $map_default_unit_type = 'mi';
  
  /**
   * $map_default_distance sets the default distance used for distance calculations
   * @var integer
   */
  var $map_default_distance = 100;
  
  /**
   * $map_markers_grouping_field sets the field to be used as the group parameter when display on a map
   * @var string
   * Example: assigned_user_name
   */
  var $map_markers_grouping_field = 'assigned_user_name';
  
  /**
   * $map_markers_groups sets the array of groups to be used to display a map
   * @var array
   */
  var $map_markers_groups = array();
  
  /**
   * $export_addresses_limit sets the query limit when selecting records to export
   * @var integer
   */
  var $export_addresses_limit = 50000;
  
  /**
   * @var google_maps_response_codes
   * 
   */
  var $google_maps_response_codes = array('OK','ZERO_RESULTS','INVALID_REQUEST','OVER_QUERY_LIMIT','REQUEST_DENIED');

  /**
   * Last Geocoding Status Message
   * @var string
   */
  var $last_status = '';

  /**
   * display_object - display module's object (dom field)
   * @var object
   */
  var $display_object;

  /**
   * related_object - related module's object (flex relate field)
   * @var object
   */
  var $related_object;
  
  /**
   * address_cache_object - Address cache module's object
   * @var object
   */
  var $address_cache_object;

  /**
   * JSON object for decoding Google Response
   * @var object
   */
  var $jsonObj;

  /**
   * smarty object for the generic configuration template
   * @var object
   */
  //var $sugarSmarty;
  
  /**
   * action geocoded_counts
   * Google Maps - Geocode the Addresses
   */
  function action_geocoded_counts() {
    
    $this->view = 'geocoded_counts';
    global $db;
    global $sugar_config;
    global $currentModule;
    //echo "<pre>";
    
    global $geocoded_counts;
    $geocoded_counts = array();
    global $geocoded_modules;
    $geocoded_modules = $this->valid_geocode_modules;
    global $geocoded_headings;
    $geocoded_headings = array('N/A');
    global $geocoded_module_totals;
    $geocoded_module_totals = array();
    
    $responses = array('N/A' => '');
    foreach ($this->google_maps_response_codes as $code) {
      if (!in_array($code, array('OVER_QUERY_LIMIT','REQUEST_DENIED'))) {
        $responses[$code] = $code;
        $geocoded_headings[] = $code;
      }
    }
    $responses['Empty'] = 'Empty';
    $geocoded_headings[] = 'Empty';
    
    // foreach module
    foreach ($this->valid_geocode_modules as $module_type) {
      
      if (!isset($geocoded_counts[$module_type])) {
        $geocoded_module_totals[$module_type] = 0;
      }
      
      // Define display object from the necessary classes (utils.php)
      $this->display_object = get_module_info($module_type);
      
      foreach ($responses as $response=>$code) {

        // Create Simple Count Query
        // 09/23/2010: Do not use create_new_list_query() and process_list_query()
        // as they will typically exceeded memory allowed.
        $query = "SELECT count(*) c FROM ".$this->display_object->table_name.
                " LEFT JOIN ".$this->display_object->table_name."_cstm ".
                " ON ".$this->display_object->table_name.".id = ".$this->display_object->table_name."_cstm.id_c ".
                " WHERE ".$this->display_object->table_name.".deleted=0 AND ";
        if ($response == 'N/A') {
          $query .= "(".$this->display_object->table_name."_cstm.jjwg_maps_geocode_status_c = '' OR ".
                $this->display_object->table_name."_cstm.jjwg_maps_geocode_status_c IS NULL)";
        } else {
          $query .= $this->display_object->table_name."_cstm.jjwg_maps_geocode_status_c = '".$code."'";
        }
        //var_dump($query);
        $count_result = $db->query($query);
        $count = $db->fetchByAssoc($count_result);
        $geocoded_counts[$module_type][$response] = $count['c'];

      } // end foreach response type
      
      // Get Totals
      $geocoded_module_totals[$module_type]++;
      $query = "SELECT count(*) c FROM ".$this->display_object->table_name." WHERE ".$this->display_object->table_name.".deleted=0";
      //var_dump($query);
      $count_result = $db->query($query);
      $count = $db->fetchByAssoc($count_result);
      $geocoded_module_totals[$module_type] = $count['c'];
      
    } // end each module type
    

  } // end function action_geocoded_counts
  

  /**
   * action geocode_addresses
   * Google Maps - Geocode the Addresses
   */
  function action_geocode_addresses() {
    
    global $db;
    global $sugar_config;
    global $currentModule;
    $this->jsonObj = new JSON(JSON_LOOSE_TYPE);
    //echo '<pre>';
    
    if (!empty($_REQUEST['display_module']) && in_array($_REQUEST['display_module'], $this->valid_geocode_modules)) {
      $geocode_modules = array($_REQUEST['display_module']);
    } else {
      $geocode_modules = $this->valid_geocode_modules;
    }
    $geocoding_inc = 0;
    $google_geocoding_inc = 0;
    
    // Define Address Cache Object
    $this->address_cache_object = get_module_info('jjwg_Address_Cache');
    
    
    foreach ($geocode_modules as $module_type) {
    
      // Define display object from the necessary classes (utils.php)
      $this->display_object = get_module_info($module_type);
      
      // Find the Items to Geocode - Get Geocode Addresses Result
      $display_result = $this->getGeocodeAddressesResult($module_type);
      
      // Iterate through the display rows
      while ($display = $db->fetchByAssoc($display_result)) {
        
        $geocoding_inc++;
        $aInfo = array();
        
        // Get address info array (address, status, lat, lng) from defineMapsAddress()
        // This will provide a related address & optionally a status, lat and lng from an account or other object
        $aInfo = $this->defineMapsAddress($this->display_object->object_name, $display);
        //var_dump($aInfo);
        
        // Attempted override of the address from the editview (status = '')
        if (!empty($display['jjwg_maps_address_c']) && empty($display['jjwg_maps_geocode_status_c'])) {
          $aInfo = $this->getGoogleMapsGeocode($display['jjwg_maps_address_c']);
        }
        
        // If needed, check the Address Cache Module for Geocode Info
        if (!empty($aInfo['address']) && !isset($aInfo['status']) && is_object($this->address_cache_object)) {
          $aInfo = $this->getAddressCacheGeocode($aInfo);
        }
        
        // If needed, Google Maps V3. Geocode the current address (status not set)
        if (!empty($aInfo['address']) && !isset($aInfo['status'])) {
          // Limit Geocode Requests to Google based on $this->google_geocoding_limit
          if ($google_geocoding_inc < $this->google_geocoding_limit) {
            $aInfo = $this->getGoogleMapsGeocode($aInfo['address']);
            $google_geocoding_inc++;
          }
        }
        //var_dump($aInfo);
        
        if (!is_numeric($aInfo['lat'])) $aInfo['lat'] = 0;
        if (!is_numeric($aInfo['lng'])) $aInfo['lng'] = 0;
        
        // Successful geocode
        // 'OK' Status
        
        if (!empty($aInfo['address']) && $aInfo['status'] == 'OK' && 
            !($aInfo['lng'] == 0 && $aInfo['lat'] == 0)) {
          
          $lngQ = $db->quote($aInfo['lng']);
          $latQ = $db->quote($aInfo['lat']);
          $idQ = $db->quote($display['id']);
          $addressQ = $db->quote($aInfo['address']);
          
          // Update Custom Fields
          $query = "UPDATE ".$this->display_object->table_name."_cstm SET".
              " jjwg_maps_lat_c = '".$latQ."',".
              " jjwg_maps_lng_c = '".$lngQ."',".
              " jjwg_maps_geocode_status_c = 'OK',".
              " jjwg_maps_address_c = '".$addressQ."'".
              " WHERE id_c = '".$display['id']."'";
          $update_result = $db->query($query);
          
          // If No Row Affected, Insert Custom Fields
          if ($db->getAffectedRowCount() != 1) {
            $query = "INSERT INTO ".$this->display_object->table_name."_cstm".
              " (id_c, jjwg_maps_lat_c, jjwg_maps_lng_c, jjwg_maps_geocode_status_c, jjwg_maps_address_c)".
              " VALUES ('".$display['id']."', '".$latQ."', '".$lngQ."', 'OK', '".$addressQ."') ";
            $insert_result = $db->query($query);
          }
          
        // Bad Geocode Results - Recorded
        // Empty Address - indicates no address, no geocode response
        // 'ZERO_RESULTS' - indicates that the geocode was successful but returned no results. 
        //     This may occur if the geocode was passed a non-existent address.
        // 'INVALID_REQUEST' - generally indicates that the query (address) is missing.
        // Also, capture empty $aInfo or address.
        
        } elseif (empty($aInfo) || empty($aInfo['address']) || (!empty($aInfo['address']) && 
              ($aInfo['status'] == 'ZERO_RESULTS' || $aInfo['status'] == 'INVALID_REQUEST'))) {
          
          if (empty($aInfo['address'])) $aInfo['address'] = '';
          if (empty($aInfo['status'])) $aInfo['status'] = 'Empty';
          $idQ = $db->quote($display['id']);
          $statusQ = $db->quote($aInfo['status']);
          $addressQ = $db->quote($aInfo['address']);
          
          // Update Custom Fields
          $query = "UPDATE ".$this->display_object->table_name."_cstm SET".
              " jjwg_maps_geocode_status_c = '".$statusQ."',".
              " jjwg_maps_address_c = '".$addressQ."'".
              " WHERE id_c = '".$display['id']."'";
          $update_result = $db->query($query);
          
          // If No Row Affected, Insert Custom Fields
          if ($db->getAffectedRowCount() != 1) {
            $query = "INSERT INTO ".$this->display_object->table_name."_cstm".
              " (id_c, jjwg_maps_geocode_status_c, jjwg_maps_address_c)".
              " VALUES ('".$display['id']."', '".$statusQ."', '".$addressQ."') ";
            $insert_result = $db->query($query);
          }
          //echo "Address " . $address;
        
        // Bad Geocode Results - Stop
        // 'OVER_QUERY_LIMIT' - indicates that you are over your quota.
        // 'REQUEST_DENIED' - indicates that your request was denied, generally because of lack of a sensor parameter.

        } elseif (!empty($aInfo['address']) && 
            ($aInfo['status'] == 'OVER_QUERY_LIMIT' || $aInfo['status'] == 'REQUEST_DENIED')) {
          
          // Set above limit to break/stop processing
          $geocoding_inc = $this->geocoding_limit + 1;
            
        } // end if/else
        
        if ($geocoding_inc > $this->geocoding_limit) break;

      } // while
      
      if ($geocoding_inc > $this->geocoding_limit) break;

    } // end each module type
    

    // If Cron processing, then do not redirect.
    if (isset($_REQUEST['cron'])) {
      exit;
    }
    
    
    // Redirect to the Geocoded Counts Display
    // contains header and exit
    $url = 'index.php?module=jjwg_Maps&action=geocoded_counts';
    if (!empty($this->last_status)) {
      $url .= '&last_status='.urlencode($this->last_status);
    }
    SugarApplication::redirect($url);

  } // end function action_geocode_addresses
  

  /**
   * Get $db result of records (addresses) in need of geocoding
   * @param $module_type string
   * @param $limit integer
   */
  private function getGeocodeAddressesResult($module_type, $limit = 0) {

    global $db;
    global $sugar_config;
    global $currentModule;
    
    if (!(in_array($module_type, $this->valid_geocode_modules))) {
      return false;
    }
    if (empty($limit) || !is_int($limit)) {
      $limit = $this->geocoding_limit;
    }
    // Define display object from the necessary classes (utils.php)
    if (!is_object($this->display_object)) {
      $this->display_object = get_module_info($module_type);
    }
    
    // Find the Items to Geocode
    // Assume there is no address at 0,0; it's in the Atlantic Ocean
    $where_conds = "(".
              "(".$this->display_object->table_name."_cstm.jjwg_maps_lat_c = 0 AND ".
              "".$this->display_object->table_name."_cstm.jjwg_maps_lng_c = 0)".
              " OR ".
              "(".$this->display_object->table_name."_cstm.jjwg_maps_lat_c IS NULL AND ".
              "".$this->display_object->table_name."_cstm.jjwg_maps_lng_c IS NULL)".
            ")".
              " AND ".
            "(".$this->display_object->table_name."_cstm.jjwg_maps_geocode_status_c = '' OR ".
            "".$this->display_object->table_name."_cstm.jjwg_maps_geocode_status_c IS NULL)";

    // Create Simple Query
    // Note: Do not use create_new_list_query() and process_list_query() as they will typically exceeded memory allowed.
    $query = "SELECT ".$this->display_object->table_name.".*, ".$this->display_object->table_name."_cstm.* FROM ".$this->display_object->table_name.
            " LEFT JOIN ".$this->display_object->table_name."_cstm ".
            " ON ".$this->display_object->table_name.".id = ".$this->display_object->table_name."_cstm.id_c ".
            " WHERE ".$this->display_object->table_name.".deleted=0 AND ".$where_conds;
    //var_dump($query);
    $display_result = $db->limitQuery($query,0,$limit);

    return $display_result;
  }
  
  
  /**
   * action getGoogleMapsGeocode
   * Get Lng/Lat using Google Maps V3
   * @var $address
   * @var $return_full_array - true or false
   */
  private function getGoogleMapsGeocode($address, $return_full_array = false) {
    
    // First check the geocode info cache
    if (!empty($this->geocode_cache[$address])) {
      $aInfo = array(
        'address' => $address,
        'status' => $this->geocode_cache[$address]['status'],
        'lat' => $this->geocode_cache[$address]['lat'],
        'lng' => $this->geocode_cache[$address]['lng']
      );
    } else {
      // Google Maps v3 - The new v3 Google Maps API no longer requires a Maps API Key!
      $base_url = "http://maps.google.com/maps/api/geocode/json?sensor=false&";
      
      $request_url = $base_url . "&address=" . urlencode($address);
      $json_contents = file_get_contents($request_url);
      //var_dump($json_contents);
      $googlemaps = $this->jsonObj->decode($json_contents);
      //var_dump($googlemaps);
      
      // Status: "OK" : all is good
      // "ZERO_RESULTS" : indicates that the geocode was successful but returned no results
      // "OVER_QUERY_LIMIT" : indicates that you are over your quota.
      // "REQUEST_DENIED" : lack of sensor parameter
      // "INVALID_REQUEST" generally indicates that the query (address or latlng) is missing.
      //echo "Status: ".$googlemaps->status."\n";
      
      if ($googlemaps && isset($googlemaps['status'])) {
        // Set the geocode info cache
        @$this->geocode_cache[$address] = array(
          'status' => $googlemaps['status'],
          'lat' => $googlemaps['results'][0]['geometry']['location']['lat'], 
          'lng' => $googlemaps['results'][0]['geometry']['location']['lng']
        );
        // Return address info
        @$aInfo = array(
          'address' => $address,
          'status' => $googlemaps['status'],
          'lat' => $googlemaps['results'][0]['geometry']['location']['lat'],
          'lng' => $googlemaps['results'][0]['geometry']['location']['lng']
        );
        // Set last status
        $this->last_status = $googlemaps['status'];
      } else {
        $aInfo = array('address' => $address);
      }
    }
    
    if ($return_full_array) {
    	return $googlemaps;
    } else {
    	return $aInfo;
    }

  }
  
  /**
   * Get the Address Info from the Address Cache Module
   * @param $aInfo
   */
  private function getAddressCacheGeocode($aInfo) {
    
    global $db;
    
    if (is_object($this->address_cache_object)) {
      $query = "SELECT ".$this->address_cache_object->table_name.".* FROM ".$this->address_cache_object->table_name." WHERE ".
              $this->address_cache_object->table_name.".deleted=0 AND ".
              $this->address_cache_object->table_name.".name='".$db->quote($aInfo['address'])."'";
      //var_dump($query);
      $cache_result = $db->limitQuery($query,0,1);
      if ($cache_result) {
        $address_cache = $db->fetchByAssoc($cache_result);
        // Note: In the jjwg_Address_Cache module the 'name' field is used for the 'address'
        if (!empty($address_cache['name']) && !($address_cache['lng'] == 0 && $address_cache['lat'] == 0) && 
            $this->is_valid_lng($address_cache['lng']) && $this->is_valid_lat($address_cache['lat'])) {
          $aInfo['address'] = $address_cache['name'];
          $aInfo['lat'] = $address_cache['lat'];
          $aInfo['lng'] = $address_cache['lng'];
          $aInfo['status'] = 'OK';
        }
      }
    }
    return $aInfo;
    
  }
  
  /**
   * export addresses in need of geocoding
   */
  function action_export_geocoding_addresses() {
    
    global $db;
    global $current_user;
    global $sugar_config;
    global $geocoding_results;
    $address_data = array();
    
    if (!empty($_REQUEST['display_module']) && in_array($_REQUEST['display_module'], $this->valid_geocode_modules)) {
      $module_type = $_REQUEST['display_module'];
    } else {
      $module_type = $this->valid_geocode_modules[0];
    }
    
    // Define display object
    if (!is_object($this->display_object)) {
      $this->display_object = get_module_info($module_type);
    }
    
    // Find the Items to Geocode - Get Geocode Addresses Result
    $display_result = $this->getGeocodeAddressesResult($module_type, $this->export_addresses_limit);
    
	$address_data[] = array('address','lat','lng');
	// Iterate through the display rows
    while ($display = $db->fetchByAssoc($display_result)) {

      // Get address info array (address, status, lat, lng) from defineMapsAddress()
      // This will provide a related address & optionally a status, lat and lng from an account or other object
      $aInfo = $this->defineMapsAddress($this->display_object->object_name, $display);
      //var_dump($aInfo);
      $address_data[] = $aInfo;
    }
    $filename = $module_type.'_Addresses_'.date("Ymd").".csv";
	$this->do_list_csv_output($address_data, $filename);
	exit;
	
  }
  
  /**
   * 
   * Export rows of data as a CSV file
   * @param unknown_type $rows
   * @param unknown_type $filename
   */
  private function do_list_csv_output($rows, $filename) {
    
    global $field_headings;
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Content-Transfer-Encoding: binary");
    if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')) {
      // IE cannot download from sessions without a cache 
      header('Cache-Control: public');
    }
    foreach (array_keys($rows) as $key) {
      $row = $rows[$key];
      echo $this->list_row_to_csv($row);
    }
  }
  
  /**
   * 
   * Create CSV row for export view
   * @param $fields name value pairs
   * @param $delimiter
   * @param $enclosure
   */
  private function list_row_to_csv($fields, $delimiter = ',', $enclosure = '"') {
    
    $delimiter_esc = preg_quote($delimiter, '/');
    $enclosure_esc = preg_quote($enclosure, '/');    
    $output = array();
    foreach ($fields as $field) {
      $output[] = preg_match("/(?:${delimiter_esc}|${enclosure_esc}|\s)/", $field) ? (
          $enclosure . str_replace($enclosure, $enclosure . $enclosure, $field) . $enclosure
          ) : $field;
    }

    return (join($delimiter, $output) . "\n");
  }

  
  /**
   * action geocoding_test
   * Google Maps - Geocoding Test
   */
  function action_geocoding_test() {
    
    $this->view = 'geocoding_test';
    global $current_user;
    global $sugar_config;
    global $geocoding_results;
    $this->jsonObj = new JSON(JSON_LOOSE_TYPE);
    
    if (!empty($_REQUEST['geocoding_address']) && !empty($_REQUEST['process_trigger']) && 
      strlen($_REQUEST['geocoding_address']) <= 255) {
        $geocoding_results = $this->getGoogleMapsGeocode($_REQUEST['geocoding_address'], true);
    }

  }
  

  /**
   * action map_display
   * Google Maps - Output the Page with IFrame to Map Markers
   */
  function action_map_display() {
    
    $this->view = 'map_display';
    global $current_user;
    global $sugar_config;

  }
  
  
  /**
   * action donate
   * Google Maps - Output the Donate Page
   */
  function action_donate() {
    
    $this->view = 'donate';
    global $current_user;
    global $sugar_config;

  }
  
  
  /**
   * action map_markers
   * Google Maps - Output the Map Markers
   */
  function action_map_markers() {
    
    $this->view = 'map_markers';
    global $db;
    global $sugar_config;
    global $currentModule;
    
    // Define globals for use in the view.
    global $map_center;
    $map_center = array();
    global $map_markers;
    $map_markers = array();
    global $map_markers_groups;
    $map_markers_groups = array();
    global $custom_markers;
    $custom_markers = array();
    global $custom_areas;
    $custom_areas = array();
    
    // Create New Sugar_Smarty Object
    $this->sugarSmarty = new Sugar_Smarty();
    global $mod_strings;
    global $app_strings;
    global $app_list_strings;
    $this->sugarSmarty->assign("mod_strings", $mod_strings);
    $this->sugarSmarty->assign("app_strings", $app_strings);
    $this->sugarSmarty->assign('moduleListSingular', $app_list_strings['moduleListSingular']);
    //echo '<pre>';
    
    // Related Map Record Defines the Map
    if ((!empty($_REQUEST['record']) || (!empty($_REQUEST['relate_id']) && !empty($_REQUEST['relate_module'])))) {
      
      // If map 'record' then define map details from current module.
      if (@is_guid($_REQUEST['record'])) {
        // Get the map object
        $map = new $currentModule();
        $map->retrieve($_REQUEST['record']);
        // Define map variables
        $map_parent_type = $map->parent_type;
        $map_parent_id   = $map->parent_id;
        $map_module_type = $map->module_type;
        $map_unit_type   = $map->unit_type;
        $map_distance    = $map->distance;
      }
      // Else if a 'relate_id' use it as the Relate Center Point (Lng/Lat)
      else if (@(is_guid($_REQUEST['relate_id']) && !empty($_REQUEST['relate_module']))) {
        // Define map variables
      	$map_parent_type = $_REQUEST['relate_module'];
        $map_parent_id   = $_REQUEST['relate_id'];
      	if (!empty($_REQUEST['display_module'])) {
      	  $map_module_type = $_REQUEST['display_module'];
      	} else {
      	  $map_module_type = $_REQUEST['relate_module'];
      	}
      	if (!empty($_REQUEST['distance'])) {
      	  $map_distance = $_REQUEST['distance'];
      	} else {
          $map_distance = $this->map_default_distance;
      	}
      	if (!empty($_REQUEST['unit_type'])) {
      	  $map_unit_type = $_REQUEST['unit_type'];
      	} else {
          $map_unit_type = $this->map_default_unit_type;
      	}
      }
      
      // Define relate and display objects
      $this->relate_object = get_module_info($map_parent_type);
      $this->display_object = get_module_info($map_module_type);
      $this->relate_object->retrieve($map_parent_id);
      
      // Get the Relate object Assoc Data
      $where_conds = $this->relate_object->table_name.".id = '".$map_parent_id."'";
      $query = $this->relate_object->create_new_list_query("".$this->relate_object->table_name.".assigned_user_id", 
                $where_conds, array(), array(), 0, '', false, $this->relate_object, false);
      //var_dump($query);
      $relate_result = $db->query($query);
      $relate = $db->fetchByAssoc($relate_result);
      
      // Add Relate (Center Point) Marker
      $map_center = $this->getMarkerData($map_parent_type, $relate, true);
      
      // Define Center Point
      $center_lat = $this->relate_object->jjwg_maps_lat_c;
      $center_lng = $this->relate_object->jjwg_maps_lng_c;
      // Define $x and $y expressions
      $x = '(69.1*(('.$this->display_object->table_name.'_cstm.jjwg_maps_lat_c)-('.$center_lat.')))';
      $y = '(53.0*(('.$this->display_object->table_name.'_cstm.jjwg_maps_lng_c)-('.$center_lng.')) * COS(('.$center_lat.')/57.1))';
      $calc_distance_expression = 'SQRT('.$x.'*'.$x.'+'.$y.'*'.$y.')';
      if (strtolower($map_unit_type) == 'km' || strtolower($map_unit_type) == 'kilometer') {
        $calc_distance_expression .= '*1.609'; // 1 mile = 1.609 km
      }
      
      // Find the Items to Display
      // Assume there is no address at 0,0; it's in the Atlantic Ocean!
      $where_conds = "(".$this->display_object->table_name."_cstm.jjwg_maps_lat_c != 0 OR ".
              "".$this->display_object->table_name."_cstm.jjwg_maps_lng_c != 0) ".
                " AND ".
              "(".$this->display_object->table_name."_cstm.jjwg_maps_geocode_status_c = 'OK')".
                " AND ".
              "(".$calc_distance_expression." < ".$map_distance.")";
      // Old Order By: "".$this->display_object->table_name.".assigned_user_id"
      $query = $this->display_object->create_new_list_query('display_object_distance', 
                $where_conds, array(), array(), 0, '', false, $this->display_object, false);
      // Add the disply_object_distance into SELECT list
      $query = str_replace('SELECT ', 'SELECT ('.$calc_distance_expression.') AS display_object_distance, ', $query);
      //var_dump($query);
      $display_result = $db->limitQuery($query, 0, $this->map_markers_limit);
      while ($display = $db->fetchByAssoc($display_result)) {
        if (!empty($map_distance) && !empty($display['id'])) {
          $map_markers[] = $this->getMarkerData($map_module_type, $display);
        }
      }
      //var_dump($map_markers);
      
      // Next define the Custom Markers and Areas related to this Map
      // Define relate and display objects from the necessary classes (utils.php)
      $markers_object = get_module_info('jjwg_Markers');
      $areas_object = get_module_info('jjwg_Areas');

      // Relationship Names: jjwg_maps_jjwg_areas and jjwg_maps_jjwg_markers

      // Find the Related Beans: Maps to Markers
      if (@(is_object($markers_object) && is_object($map))) {
        $related_custom_markers = $map->get_linked_beans('jjwg_maps_jjwg_markers', 'jjwg_Markers'); 
        if ($related_custom_markers) {
          foreach ($related_custom_markers as $marker_bean) {
            $custom_markers[] = $this->getMarkerDataCustom($marker_bean);
          }
        }
      }
      
      // Find the Related Beans: Maps to Areas
      if (@(is_object($areas_object) && is_object($map))) {
      	$related_custom_areas = $map->get_linked_beans('jjwg_maps_jjwg_areas', 'jjwg_Areas');
        if ($related_custom_areas) {
          foreach ($related_custom_areas as $area_bean) {
            $custom_areas[] = $this->getAreaDataCustom($area_bean);
          }
        }
      }
    
    
    // Map Records
    } elseif (@(!empty($_REQUEST['uid']) || !empty($_REQUEST['current_post']))) {
      
      if (in_array($_REQUEST['display_module'], $this->valid_geocode_modules)) {
        $display_module = $_REQUEST['display_module'];
      } else {
        $display_module = 'Accounts';
      }
      $this->display_object = get_module_info($display_module);

      if (@!empty($_REQUEST['uid'])) {
        $records = explode(',', $_REQUEST['uid']);
        $records_where = $this->display_object->table_name.".id IN('".implode("','",$records)."')";
      } elseif(@!empty($_REQUEST['current_post'])) {
        $ret_array = generateSearchWhere($display_module, $_REQUEST['current_post']);
        $records_where = $ret_array['where'];
      }
      //var_dump($ret_array);
      $map_markers = array();
      
      // Find the Items to Display
      // Assume there is no address at 0,0; it's in the Atlantic Ocean!
      $where_conds = "(".$this->display_object->table_name."_cstm.jjwg_maps_lat_c != 0 OR ".
              "".$this->display_object->table_name."_cstm.jjwg_maps_lng_c != 0) ".
                " AND ".
              "(".$this->display_object->table_name."_cstm.jjwg_maps_geocode_status_c = 'OK')";
      if (!empty($records_where)) {
        $where_conds .= " AND ".$records_where;
      }
      $query = $this->display_object->create_new_list_query('', 
                $where_conds, array(), array(), 0, '', false, $this->display_object, false);
      //var_dump($query);
      $display_result = $db->limitQuery($query, 0, $this->map_markers_limit);      
      while ($display = $db->fetchByAssoc($display_result)) {
            $map_markers[] = $this->getMarkerData($display_module, $display);
      } // end while
      
    }
    
    // Define the groups for the view
    $map_markers_groups = $this->map_markers_groups;
    
  } // end function action_map_markers
  
  /**
   * 
   * Define marker data for marker display view
   * @param $module_type bean name
   * @param $display bean fields array
   * TODO: Use a custom defined field for the $marker['group']
   */
  function getMarkerData($module_type, $display, $center_marker = false) {
  
    //echo "<pre>";
    //print_r($display);
    //echo "</pre>"
    
    // Define Marker
    $marker = array();
    $marker['name'] = $display['name'];
    if (empty($marker['name'])) {
      $marker['name'] = 'N/A';
    }
    $marker['id'] = $display['id'];
    $marker['module'] = $module_type;
    $marker['address'] = $display['jjwg_maps_address_c'];
    $marker['lat'] = $display['jjwg_maps_lat_c'];
    if (!$this->is_valid_lat($marker['lat'])) {
        $marker['lat'] = '0';
    }
    $marker['lng'] = $display['jjwg_maps_lng_c'];
    if (!$this->is_valid_lng($marker['lng'])) {
        $marker['lng'] = '0';
    }
    $marker['assigned_user_name'] = $display['assigned_user_name'];
    if (isset($display['marker_image'])) {
      $marker['image'] = $display['marker_image'];
    }
    // Define Marker Group
    if (!$center_marker) {
      if (!in_array($display[$this->map_markers_grouping_field], $this->map_markers_groups)) {
        $this->map_markers_groups[] = $display[$this->map_markers_grouping_field];
      }
      $marker['group'] = $display[$this->map_markers_grouping_field];
    }
    
    // Define Maps Info Window HTML by Sugar Smarty Template
    $this->sugarSmarty->assign("module_type", $module_type);
    $this->sugarSmarty->assign("address", $display['jjwg_maps_address_c']);
    $this->sugarSmarty->assign("fields", $display); // display fields array
    if (is_file('./custom/modules/jjwg_Maps/tpls/'.$module_type.'InfoWindow.tpl')) {
    	$marker['html'] = $this->sugarSmarty->fetch('./custom/modules/jjwg_Maps/tpls/'.$module_type.'InfoWindow.tpl');
    } else {
    	$marker['html'] = $this->sugarSmarty->fetch('./modules/jjwg_Maps/tpls/'.$module_type.'InfoWindow.tpl');
    }
    $marker['html'] = preg_replace('/\n\r/', ' ', $marker['html']);
    //var_dump($marker['html']);
    
    return $marker;
  
  }
  
  /**
   * 
   * Get Marker Data Custom for Mapping
   * @param $marker_object
   */
  function getMarkerDataCustom($marker_object) {

    // Define Marker
    $marker = array();
    $marker['name'] = $marker_object->name;
    if (empty($marker['name'])) {
      $marker['name'] = 'N/A';
    }
    $marker['id'] = $marker_object->id;
    $marker['lat'] = $marker_object->jjwg_maps_lat;
    if (!$this->is_valid_lat($marker['lat'])) {
        $marker['lat'] = '0';
    }
    $marker['lng'] = $marker_object->jjwg_maps_lng;
    if (!$this->is_valid_lng($marker['lng'])) {
        $marker['lng'] = '0';
    }
    $marker['image'] = $marker_object->marker_image;
    if (empty($marker['image'])) {
      $marker['image'] = 'None';
    }
    
    $fields = array();
    foreach ($marker_object->column_fields as $field) {
    	$fields[$field] = $marker_object->$field;
    }
    // Define Maps Info Window HTML by Sugar Smarty Template
    $this->sugarSmarty->assign("module_type", 'jjwg_Markers');
    $this->sugarSmarty->assign("fields", $fields); // display fields array
    if (is_file('./custom/modules/jjwg_Markers/tpls/MarkersInfoWindow.tpl')) {
    	$marker['html'] = $this->sugarSmarty->fetch('./custom/modules/jjwg_Markers/tpls/MarkersInfoWindow.tpl');
    } else {
    	$marker['html'] = $this->sugarSmarty->fetch('./modules/jjwg_Markers/tpls/MarkersInfoWindow.tpl');
    }
    $marker['html'] = preg_replace('/\n\r/', ' ', $marker['html']);
    //var_dump($marker['html']);
    
    return $marker;
  
  }
  
  /**
   * Get Area Data Custom for Mapping
   * @param $area_object
   */
  function getAreaDataCustom($area_object) {

    // Define Area
    $area = array();
    $area['name'] = $area_object->name;
    if (empty($area['name'])) {
      $area['name'] = 'N/A';
    }
    $area['id'] = $area_object->id;
    $area['coordinates'] = $area_object->coordinates;
    
    $fields = array();
    foreach ($area_object->column_fields as $field) {
    	$fields[$field] = $area_object->$field;
    }
    // Define Maps Info Window HTML by Sugar Smarty Template
    $this->sugarSmarty->assign("module_type", 'jjwg_Areas');
    $this->sugarSmarty->assign("fields", $fields); // display fields array
    if (is_file('./custom/modules/jjwg_Areas/tpls/AreasInfoWindow.tpl')) {
    	$area['html'] = $this->sugarSmarty->fetch('./custom/modules/jjwg_Areas/tpls/AreasInfoWindow.tpl');
    } else {
    	$area['html'] = $this->sugarSmarty->fetch('./modules/jjwg_Areas/tpls/AreasInfoWindow.tpl');
    }
    $area['html'] = preg_replace('/\n\r/', ' ', $area['html']);
    //var_dump($marker['html']);
    
    return $area;
  
  }
  
  /**
   * Define Maps Address
   * 
   * Address Relationship Notes:
   * Account(address)
   * Contact(address)
   * Lead(address)
   * Opportunity to Account(address)
   * Case 'account_id' to Account(address)
   *   or Case to Account(address)
   * Project to Account(address)
   *   or Project to Opportunity to Account(address)
   * @param $module_name
   * @param $display
   */
  function defineMapsAddress($module_name, $display) {
    
    global $db;
    $address = false;
    $account = false;
    //echo '<pre>';

    // Field naming is different in some modules.
    // Some modules do not have an address, so a related account needs to be found first.
    

    if (in_array($module_name, array('Account'))) {

      // Accounts
      $address = $this->defineMapsAddressBilling($display);

    } elseif (in_array($module_name, array('Contact','Lead'))) {

      // Contact & Lead
      $address = $this->defineMapsAddressPrimary($display);

    } elseif (in_array($module_name, array('Opportunity'))) {

      // Find Account - Assume only one related Account
      $query = "SELECT accounts.*, accounts_cstm.* FROM accounts LEFT JOIN accounts_cstm ON accounts.id = accounts_cstm.id_c ".
        " LEFT JOIN accounts_opportunities ON accounts.id = accounts_opportunities.account_id AND accounts_opportunities.deleted != 1 ".
        " WHERE accounts.deleted != 1 AND accounts_opportunities.opportunity_id = '".$display['id']."'";
      //var_dump($query);
      $result = $db->limitQuery($query,0,1);
      $account = $db->fetchByAssoc($result);

      if (!empty($account)) {
        $address = $this->defineMapsAddressBilling($account);
      }

    } elseif (in_array($module_name, array('aCase', 'Case'))) {

      // Find Account from Case (account_id field)
      $query = "SELECT accounts.*, accounts_cstm.* FROM accounts LEFT JOIN accounts_cstm ON accounts.id = accounts_cstm.id_c ".
        " WHERE accounts.deleted != 1 AND id = '".$display['account_id']."'";
      //var_dump($query);
      $result = $db->limitQuery($query,0,1);
      $account = $db->fetchByAssoc($result);

      // If Account is not found; Find many to many Account - Assume only one related Account
      if (empty($account)) {
        $query = "SELECT accounts.*, accounts_cstm.* FROM accounts LEFT JOIN accounts_cstm ON accounts.id = accounts_cstm.id_c ".
          " LEFT JOIN accounts_cases ON accounts.id = accounts_cases.account_id AND accounts_cases.deleted != 1 ".
          " WHERE accounts.deleted != 1 AND accounts_cases.case_id = '".$display['id']."'";
        //var_dump($query);
        $result = $db->limitQuery($query,0,1);
        $account = $db->fetchByAssoc($result);
      }
      
      if (!empty($account)) {
        $address = $this->defineMapsAddressBilling($account);
      }
    
    } elseif (in_array($module_name, array('Project'))) {
      
      // Check relationship from Project to Account - Assume only one related Account
      $query = "SELECT accounts.*, accounts_cstm.* FROM accounts LEFT JOIN accounts_cstm ON accounts.id = accounts_cstm.id_c ".
        " LEFT JOIN projects_accounts ON accounts.id = projects_accounts.account_id AND projects_accounts.deleted != 1 ".
        " WHERE accounts.deleted != 1 AND projects_accounts.project_id = '".$display['id']."'";
      //var_dump($query);
      $result = $db->limitQuery($query,0,1);
      $account = $db->fetchByAssoc($result);
      
      if (empty($account)) {
        // Find Opportunity - Assuming that the Project was created from an Opportunity (Closed Won) Detial View
        $query = "SELECT opportunities.*, opportunities_cstm.* FROM opportunities LEFT JOIN opportunities_cstm ON opportunities.id = opportunities_cstm.id_c ".
          " LEFT JOIN projects_opportunities ON opportunities.id = projects_opportunities.opportunity_id AND projects_opportunities.deleted != 1 ".
          " WHERE opportunities.deleted != 1 AND projects_opportunities.project_id = '".$display['id']."'";
        //var_dump($query);
        $result = $db->limitQuery($query,0,1);
        $opportunity = $db->fetchByAssoc($result);
        // Find Account - Assume only one related Account for the Opportunity
        $query = "SELECT accounts.*, accounts_cstm.* FROM accounts LEFT JOIN accounts_cstm ON accounts.id = accounts_cstm.id_c ".
          " LEFT JOIN accounts_opportunities ON accounts.id = accounts_opportunities.account_id AND accounts_opportunities.deleted != 1 ".
          " WHERE accounts.deleted != 1 AND accounts_opportunities.opportunity_id = '".$opportunity['id']."'";
        //var_dump($query);
        $result = $db->limitQuery($query,0,1);
        $account = $db->fetchByAssoc($result);
      }
      
      if (!empty($account)) {
        $address = $this->defineMapsAddressBilling($account);
      }
    
    }
    
    // If related account address has already been geocoded
    if (!empty($address) && $account['jjwg_maps_geocode_status_c'] == 'OK' &&
      !empty($account['jjwg_maps_lat_c']) && !empty($account['jjwg_maps_lng_c'])) {
      return array(
        'address' => $address,
        'status' => 'OK',
        'lat' => $account['jjwg_maps_lat_c'], 
        'lng' => $account['jjwg_maps_lng_c']
      );
    // elseif return address
    } elseif (!empty($address)) {
      return array(
        'address' => $address,
      );
    } else {
      return false;
    }
    
  }
  
  /**
   * 
   * Define the address based on billing address field names
   * @param $display bean fields array
   */
  function defineMapsAddressBilling($display) {
    
    $address_fields = array('billing_address_street','billing_address_city','billing_address_state','billing_address_postalcode','billing_address_country');
    foreach ($address_fields as $field) {
      if (!isset($display[$field])) $display[$field] = '';
    }
    if (strlen($display['billing_address_street'].$display['billing_address_city'].$display['billing_address_state'].
      $display['billing_address_postalcode'].$display['billing_address_country']) > 3) {
      $address_parts = array();
      foreach ($address_fields as $field) {
        if (!empty($display[$field])) $address_parts[] = trim($display[$field]);
      }
      $address = implode(', ', $address_parts);
      $address = preg_replace('/[\n\r]+/', '', $address);
      return $address;

    } else {
      return false;
    }

  }
  
  /**
   * 
   * Define the address based on primary address field names
   * @param $display bean fields array
   */
  function defineMapsAddressPrimary($display) {
    
    $address_fields = array('primary_address_street','primary_address_city','primary_address_state','primary_address_postalcode','primary_address_country');
    foreach ($address_fields as $field) {
      if (!isset($display[$field])) $display[$field] = '';
    }
    if (strlen($display['primary_address_street'].$display['primary_address_city'].$display['primary_address_state'].
      $display['primary_address_postalcode'].$display['primary_address_country']) > 3) {
      $address_parts = array();
      foreach ($address_fields as $field) {
        if (!empty($display[$field])) $address_parts[] = trim($display[$field]);
      }
      $address = implode(', ', $address_parts);
      $address = preg_replace('/[\n\r]+/', '', $address);
      return $address;

    } else {
      return false;
    }

  }
  
  /**
   * 
   * Check for valid longitude
   * @param $lng float
   */
  function is_valid_lng($lng) {
    if (is_numeric($lng) && $lng >= -180 && $lng <= 180) {
        return true;
    }
    return false;    
  }
  
  /**
   * 
   * Check for valid latitude
   * @param $lat float
   */
  function is_valid_lat($lat) {
    if (is_numeric($lat) && $lat >= -90 && $lat <= 90) {
        return true;
    }
    return false;    
  }
  
  
} // end class

?>
