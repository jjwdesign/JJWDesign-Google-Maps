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
      echo '<td><strong>'.$module.'</strong></td>';
      foreach ($geocoded_headings as $heading) {
        echo '<td>'.$geocoded_counts[$module][$heading].'</td>';
      }
      echo '<td><strong>'.$geocoded_module_totals[$module].'</strong></td>';
      echo '</tr>'."\n";
    }

    echo '</tbody></table>';
    echo '<br /><br />';
    
    echo $mod_strings['LBL_CRON_INSTRUCTIONS'];
    echo '<br /><br />';
    
    // Custom Entry Point Registry: 
    // $entry_point_registry['jjwg_Maps'] = array ('file' => 'modules/jjwg_Maps/jjwg_Maps_Router.php', 'auth' => false,);
    // Usage / Cron URL:
    // http://www.domain.com/sugarcrm/index.php?entryPoint=jjwg_Maps&cron=1
    echo $mod_strings['LBL_CRON_URL'];
    $cron_url = $sugar_config['site_url'].'/index.php?entryPoint=jjwg_Maps&cron=1';
    
    echo '<a href="'.$cron_url.'">'.$cron_url.'</a>';
    echo '<br /><br />';
    
    echo '<br /><br />';

  }
}

?>
