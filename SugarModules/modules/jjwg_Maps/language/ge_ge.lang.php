<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$mod_strings = array(
  'LBL_MAP' => 'Karte',
  'LBL_MAPS' => 'Karten',
  'LBL_MODULE_NAME' => 'Maps',
  'LBL_MODULE_TITLE' => 'Maps: Home',
  'LBL_MODULE_ID'=> 'Maps',
  'LBL_LIST_FORM_TITLE' => 'Karten',
  'LBL_MAP_CUSTOM_MARKER' => 'Marker',
  'LBL_MAP_CUSTOM_AREA' => 'Area',
  'LBL_HOMEPAGE_TITLE' => 'Karten',

  'LBL_FLEX_RELATE' => 'Bezug zu (Zentrum):',
  'LBL_MODULE_TYPE' => 'Modultyp zum Display:',
  'LBL_DISTANCE' => 'Entfernung (Radius):',
  'LBL_UNIT_TYPE' => 'Einheit:',

  'LBL_MAP_ACTION' => 'Es Karte',
  'LBL_MAP_DISPLAY' => 'Karte anzeigen',
  'LBL_MAP_LEGEND' => 'Legende:',
  'LBL_MAP_USERS' => 'Benutzer:',
  'LBL_MAP_USER_GROUPS' => 'Benutzer-Gruppen:',
  'LBL_MAP_ASSIGNED_TO' => 'zugeordnet zu:',

  'LNK_NEW_MAP' => 'neue Karte',
  'LNK_NEW_RECORD' => 'neue Karte',
  'LNK_MAP_LIST' => 'Karten anzeigen',
  'LNK_IMPORT_MAPS' => 'Karte importieren',
  'LBL_MAP_GEOCODE_ADDRESSES' => 'Adressen geocodieren',
  'LBL_MAP_DONATE' => 'Spenden',
  'LBL_MAP_DONATE_TO_THIS_PROJECT' => 'Spenden für dieses Projekt',
  'LBL_BUG_FIX' => 'Bug Fix',

  'LBL_MAP_ADDRESS_TEST' => 'Geokodierung testen',
  'LBL_MAP_QUICK_RADIUS' => 'Schnell Radius Map',
  'LBL_MAP_NULL_GROUP_NAME' => 'Keiner',
  'LBL_MAP_ADDRESS' => 'Adresse',
  'LBL_MAP_PROCESS' => 'Abfragen!',

  'LBL_MAP_LAST_STATUS' => 'Letzter Geocodierungs-Status',
  'LBL_MAP_GEOCODED_COUNTS' => 'Statistik Geokodierung',
  'LBL_GEOCODED_COUNTS' => 'Modul Statistik Geokodierung',
  'LBL_CRON_URL' => 'Cron URL:',
  'LBL_MODULE_HEADING' => 'Modul',
  'LBL_MODULE_TOTAL_HEADING' => 'Insgesamt',
  'LBL_GEOCODED_COUNTS_DESCRIPTION' => 'Die Tabelle unten zeigt die Anzahl der geocodiert Objekte gruppiert nach Modul und Geocodierungs-Status. '. 
    'Beachten Sie, dass normalerweise die Google-Geocodierung auf 2500 Zugriffe pro Tag beschränkt ist. '.
    'Dieses Modul speichert die geocodierten Adressen-Informationen während der Verarbeitung, um die Gesamtzahl der Zugriffe zu reduzieren.',
  'LBL_CRON_URL' => 'CRON URL',
  'LBL_CRON_INSTRUCTIONS' => 'Wir empfehlen einen nächtlichen Cron-Job zur Geocodierung. '.
    'Zu diesem Zweck exisitiert ein benutzerdefinierter Einstiegspunkt, auf den ohne Authentifizierung zugegriffen werden kann. '.
    'Die unten angegebene URL kann im Zeitplaner als geplante Aufgabe verwendet werden. '.
    'Bitte beachten Sie hierzu auch die SugarCRM-Dokumentation.',
  'LBL_EXPORT_ADDRESS_URL' => 'Export-URLs',
  'LBL_EXPORT_INSTRUCTIONS' => 'Verwenden Sie die folgenden Links, um die vollständige Anschrift benötigen geocodeing Informationen zu exportieren. '.
    'Dann verwenden Sie eine Online-oder Offline Batch Geocoding-Tool, um die Adressen Geocode. '.
    'Wenn Sie fertig sind Geocodierung, importieren Sie die Adressen in die Adress-Cache-Modul mit Ihren Karten verwendet werden. '.
    'Beachten Sie, dass die Adress-Cache-Modul optional. Alle geocoding Informationen sind in der Vertreter-Modul gespeichert.',

    
    'LBL_CONFIG_TITLE' => 'Configuration Settings',
    'LBL_CONFIG_SAVED' => 'Settings Saved Successfully!',
    'LBL_BILLING_ADDRESS' => 'Billing Address',
    'LBL_SHIPPING_ADDRESS' => 'Shipping Address',
    'LBL_PRIMARY_ADDRESS' => 'Primary Address',
    'LBL_ALTERNATIVE_ADDRESS' => 'Alternative Address',
    'LBL_FLEX_RELATE' => 'Flex Relate',
    'LBL_ENABLED' => 'Enabled',
    'LBL_DISABLED' => 'Disabled',
    'LBL_DEFAULT' => 'Default:',
    'LBL_CONFIG_DEFAULT' => 'Default:',

    'LBL_CONFIG_ADDRESS_TYPE_SETTINGS_TITLE' => "Address Type Settings: This defines the modules' address types used when geocoding addresses. Acceptable Values: 'billing', 'shipping', 'primary', 'alt', 'flex_relate'",
    'LBL_CONFIG_ADDRESS_TYPE_FOR_ACCOUNTS' => 'Address Type for Accounts:',
    'LBL_CONFIG_ADDRESS_TYPE_FOR_CONTACTS' => 'Address Type for Contacts:',
    'LBL_CONFIG_ADDRESS_TYPE_FOR_LEADS' => 'Address Type for Leads:',
    'LBL_CONFIG_ADDRESS_TYPE_FOR_OPPORTUNITIES' => 'Address Type for Opportunities:',
    'LBL_CONFIG_OF_RELATED_ACCOUNT' => '(of Related Account)',
    'LBL_CONFIG_ADDRESS_TYPE_FOR_CASES' => 'Address Type for Cases:',
    'LBL_CONFIG_ADDRESS_TYPE_FOR_PROJECTS' => 'Address Type for Projects:',
    'LBL_CONFIG_OF_RELATED_ACCOUNT_OPPORTUNITY' => '(of Related Account/Opportunity)',
    'LBL_CONFIG_ADDRESS_TYPE_FOR_MEETINGS' => 'Address Type for Meetings:',
    'LBL_CONFIG_ADDRESS_TYPE_FOR_PROSPECTS' => 'Address Type for Prospects/Targets:',
    'LBL_CONFIG_RELATED_OBJECT_THRU_FLEX_RELATE' => 'Related Object thru Flex Relate Field',

    'LBL_CONFIG_MARKER_GROUP_FIELD_SETTINGS_TITLE' => "Marker Group Field Settings: This defines the 'field' to be used as the group parameter when displaying markers on a map. Examples: assigned_user_name, industry, status, sales_stage, priority",
    'LBL_CONFIG_GROUP_FIELD_FOR_ACCOUNTS' => 'Group Field for Accounts:',
    'LBL_CONFIG_GROUP_FIELD_FOR_CONTACTS' => 'Group Field for Contacts:',
    'LBL_CONFIG_GROUP_FIELD_FOR_LEADS' => 'Group Field for Leads:',
    'LBL_CONFIG_GROUP_FIELD_FOR_OPPORTUNITIES' => 'Group Field for Opportunities:',
    'LBL_CONFIG_GROUP_FIELD_FOR_CASES' => 'Group Field for Cases:',
    'LBL_CONFIG_GROUP_FIELD_FOR_PROJECTS' => 'Group Field for Projects:',
    'LBL_CONFIG_GROUP_FIELD_FOR_MEETINGS' => 'Group Field for Meetings:',
    'LBL_CONFIG_GROUP_FIELD_FOR_PROSPECTS' => 'Group Field for  Prospects/Targets:',

    'LBL_CONFIG_GEOCODING_SETTINGS_TITLE' => 'Geocoding/Google Settings:',
    'LBL_CONFIG_GEOCODING_LIMIT_TITLE' => 'Geocoding Limit:',
    'LBL_CONFIG_GEOCODING_LIMIT_DESC' => "'geocoding_limit' sets the query limit when selecting records to geocode.",
    'LBL_CONFIG_GOOGLE_GEOCODING_LIMIT_TITLE' => 'Google Geocoding Limit:',
    'LBL_CONFIG_GOOGLE_GEOCODING_LIMIT_DESC' => "'google_geocoding_limit' sets the request limit when geocoding using the Google Maps API.",
    'LBL_CONFIG_EXPORT_ADDRESSES_LIMIT_TITLE' => 'Export Addresses Limit:',
    'LBL_CONFIG_EXPORT_ADDRESSES_LIMIT_DESC' => "'export_addresses_limit' sets the query limit when selecting records to export.",

    'LBL_CONFIG_ADDRESS_CACHE_SETTINGS_TITLE' => 'Address Cache Settings:',
    'LBL_CONFIG_ADDRESS_CACHE_GET_ENABLED_TITLE' => 'Enable Address Cache (Get):',
    'LBL_CONFIG_ADDRESS_CACHE_GET_ENABLED_DESC' => "'address_cache_get_enabled' allows the address cache module to retrieve data from the cache table.",
    'LBL_CONFIG_ADDRESS_CACHE_SAVE_ENABLED_TITLE' => 'Enable Saving Address Cache (Save):',
    'LBL_CONFIG_ADDRESS_CACHE_SAVE_ENABLED_DESC' => "'address_cache_save_enabled' allows the address cache module to save data to the cache table.",
    
    'LBL_CONFIG_LOGIC_HOOKS_SETTINGS_TITLE' => 'Logic Hooks Setting:',
    'LBL_CONFIG_LOGIC_HOOKS_ENABLED_TITLE' => 'Enable All Logic Hooks: ',
    'LBL_CONFIG_LOGIC_HOOKS_ENABLED_DESC' => "'logic_hooks_enabled' allows logic hooks for automatic updating based on related objects. It is recommended to disable when upgrading your SugarCRM.",
    
    'LBL_CONFIG_MARKER_MAPPING_SETTINGS_TITLE' => 'Marker/Mapping Settings:',
    'LBL_CONFIG_MAP_MARKERS_LIMIT_TITLE' => "Map Markers Limit:",
    'LBL_CONFIG_MAP_MARKERS_LIMIT_DESC' => "'map_markers_limit' sets the query limit when selecting records to display on a map.",
    'LBL_CONFIG_MAP_DEFAULT_CENTER_LATITUDE_TITLE' => "Map Default Center Latitude:",
    'LBL_CONFIG_MAP_DEFAULT_CENTER_LATITUDE_DESC' => "'map_default_center_latitude' sets the default center latitude position for maps.",
    'LBL_CONFIG_MAP_DEFAULT_CENTER_LONGITUDE_TITLE' => "Map Default Center Longitude:",
    'LBL_CONFIG_MAP_DEFAULT_CENTER_LONGITUDE_DESC' => "'map_default_center_longitude' sets the default center longitude position for maps.",
    'LBL_CONFIG_MAP_DEFAULT_UNIT_TYPE_TITLE' => "Map Default Unit Type:",
    'LBL_CONFIG_MAP_DEFAULT_UNIT_TYPE_DESC' => "'map_default_unit_type' sets the default unit measurement type for distance calculations. Values: 'mi' (miles) or 'km' (kilometers).",
    'LBL_CONFIG_MAP_DEFAULT_DISTANCE_TITLE' => "Map Default Distance:",
    'LBL_CONFIG_MAP_DEFAULT_DISTANCE_DESC' => "'map_default_distance' sets the default distance used for distance based maps.",
    'LBL_CONFIG_MAP_DUPLICATE_MARKER_ADJUSTMENT_TITLE' => "Map Duplicate Marker Adjustment:",
    'LBL_CONFIG_MAP_DUPLICATE_MARKER_ADJUSTMENT_DESC' => "'map_duplicate_marker_adjustment' sets an offset adjustment to be added to longitude and latitude in case of duplicate marker position.",
    'LBL_CONFIG_MAP_CLUSTER_GRID_SIZE_TITLE' => "Map Markers Clusterer Grid Size:",
    'LBL_CONFIG_MAP_CLUSTER_GRID_SIZE_DESC' => "'map_clusterer_grid_size' is used to set the grid size for calculating map clusterers.",
    'LBL_CONFIG_MAP_MARKERS_CLUSTERER_MAX_ZOOM_TITLE' => "Map Markers Clusterer Max Zoom:",
    'LBL_CONFIG_MAP_MARKERS_CLUSTERER_MAX_ZOOM_DESC' => "'map_clusterer_max_zoom' is used to set the maximum zoom level at which clustering will not be applied.",
    'LBL_CONFIG_CUSTOM_CONTROLLER_DESC' => "Important Note: All saved settings can be found in the 'config' table under category 'jjwg'. Note, a custom controller.php file should no longer be used to override settings.",
    
  
);

?>
