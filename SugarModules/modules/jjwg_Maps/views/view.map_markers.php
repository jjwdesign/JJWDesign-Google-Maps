<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class Jjwg_MapsViewMap_Markers extends SugarView {

  function Jjwg_MapsViewMap_Markers() {
    parent::SugarView();
  }

  function display() {
    
    global $sugar_config;
    global $currentModule;
    global $theme;
    global $mod_strings;

    // Define globals for use in the view.
    global $map_center; // center marker
    global $map_markers; // grouped markers
    global $map_markers_groups; // array of grouping names
    // Pro Version
    global $custom_markers;
    global $custom_areas;
    
    $num_markers = count($map_markers);
    $num_groups = count($map_markers_groups);
    if ($num_groups > 216) $num_groups = 216;
    $group_name_to_icon_num = array();
    $i = 1;
    // Define Group Name to Icon Number Mapping 1-216(max)
    foreach ($map_markers_groups as $name) {
    	$group_name_to_num[$name] = $i;
    	$i++;
    }
    // Define Dir of Group Icons
    $icons_dir_base = 'modules/jjwg_Maps/images/icons/';
    if ($num_groups <= 10 && is_dir($icons_dir_base.'0-10')) {
      $icons_dir = $icons_dir_base.'0-10';
    } elseif ($num_groups <= 25 && is_dir($icons_dir_base.'0-25')) {
      $icons_dir = $icons_dir_base.'0-25';
    } elseif ($num_groups <= 100 && is_dir($icons_dir_base.'0-100')) {
      $icons_dir = $icons_dir_base.'0-100';
    } elseif ($num_groups <= 216 && is_dir($icons_dir_base.'0-216')) {
      $icons_dir = $icons_dir_base.'0-216';
    } else {
      $icons_dir = $icons_dir_base.'0-10'; // Demo Version
    }

    // Define Custom Markers Dir and Common Icons
    $custom_markers_dir = 'modules/jjwg_Markers/images/icons/';
    $custom_markers_icons = array();
    foreach($custom_markers as $marker) {
      $custom_markers_icons[] = $marker['image'];
    }
    $custom_markers_icons = array_unique($custom_markers_icons);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
 
<html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
  <title><?php echo $mod_strings['LBL_MAP_DISPLAY']; ?></title> 
  <meta http-equiv="content-type" content="text/html; charset=utf-8"/> 
  <link rel="stylesheet" type="text/css" href="cache/themes/<?php echo $theme; ?>/css/style.css ?>" />
  <style type="text/css">
    html,body{
      margin:0;
      padding:0;
      width:100%;
      height:100%;
      font-family:Arial, Helvetica, sans-serif;
    }
    #map_canvas {
      width: 100%;
      height: 500px;
      border: 0;
    }
    div.marker {
      font-size: 12px;
      font-family:Arial,Verdana,Helvetica,sans-serif;
      overflow: hidden;
    }
    #legend {
      width: 100%;
      font-size: 12px;
      line-height: 16px;
      font-family:Arial,Verdana,Helvetica,sans-serif;
      color: #444444;
      font-weight: normal;  
    }
    b {
      font-size: 12px;
      line-height: 16px;
      font-weight: bold;
      color: #000000;
    }
  </style>
  <script src="http://www.google.com/jsapi"></script>
  <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
  <script type="text/javascript" src="modules/jjwg_Maps/javascript/markerclusterer.js"></script>
  <script type="text/javascript">

function initialize() {
  
  var myOptions = {
    zoom: 3,
    center: new google.maps.LatLng(43.9,-101.2),
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
  var bounds = new google.maps.LatLngBounds();

  var markers = [];

  // Define the Marker Images
  var markerImage = [];
<?php
  for ($i=0;$i<=count($map_markers_groups);$i++) {
?>
markerImage[<?php echo $i; ?>] = new google.maps.MarkerImage('<?php echo $icons_dir; ?>/marker_<?php echo $i; ?>.png',
new google.maps.Size(20,34), new google.maps.Point(0,0), new google.maps.Point(10,34));
<?php
  } // end for Marker Images
?>

  var shape = {coord: [1, 1, 1, 34, 20, 34, 20, 1],type: 'poly'};
<?php
  // Center Marker
  if (!empty($map_center)) {
    $loc = $map_center;
?>
var myLatLng0 = new google.maps.LatLng('<?php echo $loc['lat']; ?>', '<?php echo $loc['lng']; ?>');
var marker0 = new google.maps.Marker({
position: myLatLng0,
map: map,
icon: markerImage[0],
shape: shape,
title: '<?php echo javascript_escape($loc['name']); ?>',
zIndex: 99
});
bounds.extend(myLatLng0);
var infowindow0 = new google.maps.InfoWindow();
google.maps.event.addListener(marker0, 'click', function() {
infowindow0.open(map, marker0);
infowindow0.setContent('<?php echo javascript_escape($loc['html']); ?>');
});

<?php
  } // end if
?>

<?php
  // Marker Locations
  for ($i=0;$i<$num_markers;$i++) {
    $loc = $map_markers[$i];
    if (empty($loc['group'])) $loc['group'] = 1;
?>
var myLatLng<?php echo $i+1; ?> = new google.maps.LatLng('<?php echo $loc['lat']; ?>', '<?php echo $loc['lng']; ?>');
var marker<?php echo $i+1; ?> = new google.maps.Marker({
position: myLatLng<?php echo $i+1; ?>,
map: map,
icon: markerImage[<?php echo $group_name_to_num[$loc['group']]; ?>],
shape: shape,
title: '<?php echo javascript_escape($loc['name']); ?>',
zIndex: 5
});
bounds.extend(myLatLng<?php echo $i+1; ?>);
var infowindow<?php echo $i+1; ?> = new google.maps.InfoWindow();
google.maps.event.addListener(marker<?php echo $i+1; ?>, 'click', function() {
infowindow<?php echo $i+1; ?>.open(map, marker<?php echo $i+1; ?>);
infowindow<?php echo $i+1; ?>.setContent('<?php echo javascript_escape($loc['html']); ?>');
});
markers.push(marker<?php echo $i+1; ?>);

<?php
  } // end for
?>

  var markerClusterer = new MarkerClusterer(map, markers, { maxZoom: 16, gridSize: 60, });
  
  
  
  
  // Define the Custom Marker Images (jjwg_Markers Module)
  var customImage = [];
<?php
  if (count($custom_markers) > 0) {
  
    foreach ($custom_markers_icons as $image) {
?>
      customImage<?php echo javascript_escape($image) ?> = new google.maps.MarkerImage('<?php echo $custom_markers_dir; ?>/<?php echo javascript_escape($image); ?>.png',
        new google.maps.Size(32,37),
        new google.maps.Point(0,0),
        new google.maps.Point(16,37)
      );
<?php
    } // end for
?>
    var shape = {coord: [1, 1, 1, 37, 32, 37, 32, 1],type: 'poly'};

<?php
    // Inc the previous marker counter
    $i++;
    // Custom Marker Locations
    foreach ($custom_markers as $loc) {
?>
      var myLatLng<?php echo $i; ?> = new google.maps.LatLng('<?php echo $loc['lat']; ?>', '<?php echo $loc['lng']; ?>');
      var marker<?php echo $i; ?> = new google.maps.Marker({
        position: myLatLng<?php echo $i; ?>,
        map: map,
        icon: customImage<?php echo javascript_escape($loc['image']) ?>,
        shape: shape,
        title: '<?php echo javascript_escape($loc['name']); ?>',
        zIndex: 25
      });
      bounds.extend(myLatLng<?php echo $i; ?>);
      var infowindow<?php echo $i; ?> = new google.maps.InfoWindow();
      infowindow<?php echo $i; ?>.setContent('<?php echo javascript_escape($loc['html']).' '; ?>');
      google.maps.event.addListener(marker<?php echo $i; ?>, 'click', function() {
        infowindow<?php echo $i; ?>.open(map, marker<?php echo $i; ?>);
      });
<?php
      // Inc the marker counter
      $i++;
    } // end of foreach $custom_markers
  
  } // end if $custom_markers
?>


  
  

  // Define the Custom Area Polygons (jjwg_Areas Module)
<?php
  if (count($custom_areas) > 0) {
      
    foreach ($custom_areas as $area) {

      $polygon = explode(' ', $area['coordinates']);      
      $j = 0;
      if (count($polygon) > 0) {
        foreach ($polygon as $coord) {
          $p = explode(',', $coord);
          $loc['lng'] = $p[0];
          $loc['lat'] = $p[1];
          $loc['elv'] = $p[2];
?>
          var myLatLng<?php echo $j; ?> = new google.maps.LatLng('<?php echo $loc['lat']; ?>','<?php echo $loc['lng']; ?>');
          bounds.extend(myLatLng<?php echo $j; ?>);
<?php
          $j++;
        }
      }
      if (count($polygon) > 0) {
?>var myCoords = [<?php
        for($k=0;$k<count($polygon);$k++) {
        	if ($k == 0) {
?><?php
        	}
?>myLatLng<?php echo $k; ?><?php if ($k != count($polygon)-1) echo ','; ?>
<?php
        }
?>];
      var myAreaPolygon<?php echo $i; ?> = new google.maps.Polygon({
        paths: myCoords,
        strokeColor: "#000099",
        strokeOpacity: 0.8,
        strokeWeight: 1,
        fillColor: "#000099",
        fillOpacity: 0.20
      });
      myAreaPolygon<?php echo $i; ?>.setMap(map);
      
      infowindow<?php echo $i; ?> = new google.maps.InfoWindow();
      infowindow<?php echo $i; ?>.setContent('<?php echo javascript_escape($area['html']).' '; ?>');
      google.maps.event.addListener(myAreaPolygon<?php echo $i; ?>, 'click', function(event) {
        infowindow<?php echo $i; ?>.setPosition(event.latLng);
        infowindow<?php echo $i; ?>.open(map);
      });

<?php
      }
?>
<?php
      // Inc the marker/area counter for InfoWindow
      $i++;
    } // end of foreach $custom_markers
  
  } // end if $custom_markers
?>




  // Lastly
  map.fitBounds(bounds);

}

</script>

</head>

<body onload="initialize()">
  
  <div id="map_canvas"></div>
  <br clear="all" />
  <div id="legend">
  <b><?php echo $mod_strings['LBL_MAP_LEGEND']; ?> </b>
<?php
  if (!empty($map_center)) {
?>
    <img src="<?php echo $sugar_config['site_url'].'/'.$icons_dir.'/marker_0.png'; ?>" align="middle" />
    <?php echo $map_center['name']; ?>, 
<?php
  }
?>
  &nbsp; <b><?php echo $mod_strings['LBL_MAP_USER_GROUPS']; ?> </b>
<?php
  $i = 1;
  foreach($group_name_to_num as $group_name => $group_number) {
?>
    <img src="<?php echo $sugar_config['site_url'].'/'.$icons_dir.'/marker_'.$group_number.'.png'; ?>" align="middle" />
    <?php echo htmlentities($group_name, ENT_COMPAT, "UTF-8", false); ?><?php if ($i != $num_groups) echo ','; ?>
<?php
    $i++;
  }
?>   
  </div>
  
</body> 
</html>
<?php

   }
}

?>
