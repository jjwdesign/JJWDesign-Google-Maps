<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class Jjwg_MapsViewGeocoded_Counts extends SugarView {

   function Jjwg_MapsViewGeocoded_Counts() {
     parent::SugarView();
   }

  function display() {
    
    global $sugar_config;
    global $currentModule;
    global $theme;
    global $mod_strings;
    global $app_strings;
    global $app_list_strings;
    
    global $geocoded_counts;
    global $geocoded_modules;
    global $geocoded_headings;
    global $geocoded_module_totals;
    
    echo '<div class="moduleTitle"><h2>'.$mod_strings['LBL_GEOCODED_COUNTS'].'</h2></div>';
    echo $mod_strings['LBL_GEOCODED_COUNTS_DESCRIPTION'];
    echo '<br /><br />';

    // Display last status code, if set.
    if (!empty($_REQUEST['last_status']) && preg_match('/[A-Z\_]/', $_REQUEST['last_status'])) {
      echo '<div><b>'.$mod_strings['LBL_MAP_LAST_STATUS'].': '.$_REQUEST['last_status'].'</b></div>';
      echo '<br /><br />';
    }

    echo '<table width="25%" cellspacing="0" cellpadding="0" border="0" class="list view" style="width: 25% !important;"><tbody>';
    echo '<tr><th>'.$mod_strings['LBL_MODULE_HEADING'].'</th>';
    foreach ($geocoded_headings as $heading) {
      echo '<th>'.$heading.'</th>';
    }
    echo '<th>'.$mod_strings['LBL_MODULE_TOTAL_HEADING'].'</th>';
    echo '</tr>'."\n";
    foreach ($geocoded_modules as $module) {
      echo '<tr>';
      echo '<td><strong>'.$app_list_strings['moduleList'][$module].'</strong></td>';
      foreach ($geocoded_headings as $heading) {
        echo '<td>'.$geocoded_counts[$module][$heading].'</td>';
      }
      echo '<td><strong>'.$geocoded_module_totals[$module].'</strong></td>';
      echo '</tr>'."\n";
    }

    echo '</tbody></table>';
    echo '<br /><br />';
    
    // Custom Entry Point Registry: 
    // $entry_point_registry['jjwg_Maps'] = array('file' => 'modules/jjwg_Maps/jjwg_Maps_Router.php', 'auth' => false);
    // Usage / Cron URL: index.php?module=jjwg_Maps&entryPoint=jjwg_Maps&cron=1

    echo '<strong>'.$mod_strings['LBL_CRON_URL'].'</strong>';
    echo '<br /><br />';
    echo $mod_strings['LBL_CRON_INSTRUCTIONS'];
    echo '<br /><br />';

    $cron_url = $sugar_config['site_url'].'/index.php?module=jjwg_Maps&entryPoint=jjwg_Maps&cron=1';

    echo '<a href="'.$cron_url.'">'.$cron_url.'</a>';
    echo '<br /><br />';
    echo '<br /><br />';

    echo '<strong>'.$mod_strings['LBL_EXPORT_ADDRESS_URL'].'</strong>';
    echo '<br /><br />';

    echo $mod_strings['LBL_EXPORT_INSTRUCTIONS'];
    echo '<br /><br />';

    $export_url = $sugar_config['site_url'].'/index.php?module=jjwg_Maps&action=export_geocoding_addresses&display_module=';

    echo '<a target="_blank" href="'.$export_url.'Leads">'.$app_strings['LBL_EXPORT'].' '.$app_strings['LBL_LEADS'].'</a>';
    echo '<br /><br />';
    echo '<a target="_blank" href="'.$export_url.'Accounts">'.$app_strings['LBL_EXPORT'].' '.$app_strings['LBL_ACCOUNTS'].'</a>';
    echo '<br /><br />';
    echo '<a target="_blank" href="'.$export_url.'Contacts">'.$app_strings['LBL_EXPORT'].' '.$app_strings['LBL_CONTACTS'].'</a>';
    echo '<br /><br />';
    echo '<a target="_blank" href="'.$export_url.'Prospects">'.$app_strings['LBL_EXPORT'].' Prospects'.'</a>';
    echo '<br /><br />';
    
    echo '<br /><br />';

  }
}

