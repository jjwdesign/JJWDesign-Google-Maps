<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class Jjwg_MapsViewMap_Markers extends SugarView {

  function Jjwg_MapsViewMap_Markers() {
    parent::SugarView();
  }

  function display() {
    
    $jsonObj = new JSON(JSON_LOOSE_TYPE);
    
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
 
<html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
  <title><?php echo $GLOBALS['mod_strings']['LBL_MAP_DISPLAY']; ?></title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
  <link rel="stylesheet" type="text/css" href="cache/themes/<?php echo $GLOBALS['theme']; ?>/css/style.css" />
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
      margin:0;
      padding:0;
      border: 0;
    }
    div.marker {
      font-size: 12px;
      font-family:Arial,Verdana,Helvetica,sans-serif;
      overflow: hidden;
    }
    #legend {
      background: rgba(100%, 100%, 100%, 0.60);
      padding: 5px;
      margin: 5px;
      border: 1px solid #999999;
      width: 140px;
      min-width: 140px;
      overflow-x: auto;
      max-height: 440px;
      overflow-y: auto;
      white-space: nowrap;
      font-size: 12px;
      line-height: 16px;
      font-family:Arial,Verdana,Helvetica,sans-serif;
      color: #333333;
    }
    #legend b {
      font-weight: bold;
      font-family:Arial,Verdana,Helvetica,sans-serif;
      color: #333333;
    }
    #legend img {
      vertical-align: middle;
      margin: 1px;
      border: none;
    }
    
    b {
      font-size: 12px;
      line-height: 16px;
      font-weight: bold;
      color: #000000;
    }
  </style>
  <link rel="stylesheet" type="text/css" href="modules/jjwg_Maps/DataTables/media/css/jquery.dataTables.css" />
  <script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=false"></script>
  <script type="text/javascript" src="modules/jjwg_Areas/javascript/jquery-1.8.0.min.js"></script>
  <script type="text/javascript" src="modules/jjwg_Maps/javascript/markerclusterer_packed.js"></script>
  <script type="text/javascript" src="modules/jjwg_Maps/DataTables/media/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript">
// Define SugarCRM App data for Javascript
var dictionary = <?php echo (!empty($GLOBALS['dictionary'])) ? $jsonObj->encode($GLOBALS['dictionary']) : '[]'; ?>;
var app_strings = <?php echo (!empty($GLOBALS['app_strings'])) ? $jsonObj->encode($GLOBALS['app_strings']) : '[]'; ?>;
var app_list_strings = <?php echo (!empty($GLOBALS['app_list_strings'])) ? $jsonObj->encode($GLOBALS['app_list_strings']) : '[]'; ?>;
var mod_strings = <?php echo (!empty($GLOBALS['mod_strings'])) ? $jsonObj->encode($GLOBALS['mod_strings']) : '[]'; ?>;
// Define Map Data for Javascript
var jjwg_config_defaults = <?php echo (!empty($GLOBALS['jjwg_config_defaults'])) ? $jsonObj->encode($GLOBALS['jjwg_config_defaults']) : '[]'; ?>;
var jjwg_config = <?php echo (!empty($GLOBALS['jjwg_config'])) ? $jsonObj->encode($GLOBALS['jjwg_config']) : '[]'; ?>;
<?php
sort($GLOBALS['map_markers_groups']);
// Check to see if map center is empty of lng,lat of 0,0
if (empty($GLOBALS['map_center']) || (empty($GLOBALS['map_center']['lat']) && empty($GLOBALS['map_center']['lng']))) {
    // Ensure something shows on the map
    if (empty($GLOBALS['map_markers']) && empty($GLOBALS['custom_markers']) && empty($GLOBALS['custom_areas'])) {
        // Define default point as map center
        $GLOBALS['map_center']['lat'] = $GLOBALS['jjwg_config']['map_default_center_latitude'];
        $GLOBALS['map_center']['lng'] = $GLOBALS['jjwg_config']['map_default_center_longitude'];
        if (!isset($GLOBALS['map_center']['html'])) $GLOBALS['map_center']['html'] = $GLOBALS['mod_strings']['LBL_DEFAULT'];
        if (!isset($GLOBALS['map_center']['html'])) $GLOBALS['map_center']['name'] = $GLOBALS['mod_strings']['LBL_DEFAULT'];
    }
}
?>
var map_center = <?php echo (!empty($GLOBALS['map_center'])) ? $jsonObj->encode($GLOBALS['map_center']) : 'null'; ?>;
var map_markers = <?php echo (!empty($GLOBALS['map_markers'])) ? $jsonObj->encode($GLOBALS['map_markers']) : '[]'; ?>;
var map_markers_groups = <?php echo (!empty($GLOBALS['map_markers_groups'])) ? $jsonObj->encode($GLOBALS['map_markers_groups']) : '[]'; ?>;
var custom_markers = <?php echo (!empty($GLOBALS['custom_markers'])) ? $jsonObj->encode($GLOBALS['custom_markers']) : '[]'; ?>;
var custom_areas = <?php echo (!empty($GLOBALS['custom_areas'])) ? $jsonObj->encode($GLOBALS['custom_areas']) : '[]'; ?>;
<?php
    // Define Map Data
    $num_markers = count($GLOBALS['map_markers']);
    $num_groups = count($GLOBALS['map_markers_groups']);
    if ($num_groups > 216) $num_groups = 216;
    $group_name_to_num = array();
    $i = 1;
    // Define Group Name to Icon Number Mapping 1-216(max)
    if (!empty($GLOBALS['map_markers_groups'])) {
        foreach ($GLOBALS['map_markers_groups'] as $name) {
            $group_name_to_num[$name] = $i;
            $i++;
        }
    }
    // Define Dir of Group Icons
    $icons_dir_base = 'custom/themes/default/images/jjwg_Maps/';
    if ($num_groups <= 10) {
      $icons_dir = $icons_dir_base.'0-10/';
    } elseif ($num_groups <= 25) {
      $icons_dir = $icons_dir_base.'0-25/';
    } elseif ($num_groups <= 100) {
      $icons_dir = $icons_dir_base.'0-100/';
    } elseif ($num_groups <= 216) {
      $icons_dir = $icons_dir_base.'0-216/';
    } else {
      $icons_dir = $icons_dir_base.'0-10/'; // Demo Version
    }
    
    // Define Custom Markers Dir and Common Icons
    $custom_markers_dir = 'custom/themes/default/images/jjwg_Markers/';
    $custom_markers_icons = array();
    foreach($GLOBALS['custom_markers'] as $marker) {
      $custom_markers_icons[] = $marker['image'];
    }
    $num_custom_markers = count($GLOBALS['custom_markers']);
    $custom_markers_icons = array_unique($custom_markers_icons);
?>

// Define Map Data for Javascript
var num_markers = <?php echo (!empty($num_markers)) ? $jsonObj->encode($num_markers) : '0'; ?>;
var num_groups = <?php echo (!empty($num_groups)) ? $jsonObj->encode($num_groups) : '0'; ?>;
var group_name_to_num = <?php echo (!empty($group_name_to_num)) ? $jsonObj->encode($group_name_to_num) : '[]'; ?>;
var icons_dir = <?php echo (!empty($icons_dir)) ? $jsonObj->encode($icons_dir) : "'custom/themes/default/images/jjwg_Maps/0-10/'"; ?>;
var num_custom_markers = <?php echo (!empty($num_custom_markers)) ? $jsonObj->encode($num_custom_markers) : '0'; ?>;
var custom_markers_dir = <?php echo (!empty($custom_markers_dir)) ? $jsonObj->encode($custom_markers_dir) : "'custom/themes/default/images/jjwg_Markers/'"; ?>;
var custom_markers_icons = <?php echo (!empty($custom_markers_icons)) ? $jsonObj->encode($custom_markers_icons) : '[]'; ?>;


/******************************************************************************/


// Define map vars
var map = null;
var bounds = null;
var loc = [];
var myLatLng = [];

// MarkerImage objects
var markerImage = [];
var shape = null;

// Marker objects
var marker = [];
var markerGroupVisible = [];

// Legend and Clusterer Control
var legend = null;
var markerClusterer = null;
var markerClustererToggle = null;
var clusterControlDiv = null;

// InfoWindow objects: array of InfoWindow objects used for all markers, custom markers and custom areas
var infowindow = [];

// All types of Marker objects
var markers = [];

// Areas/Polygons objects
var myAreaPolygon = null;


function setCenterMarker() {
  
    // Center Marker - marker[0]
    if (map_center !== null) {
        loc[0] = map_center;
        myLatLng[0] = new google.maps.LatLng(loc[0].lat, loc[0].lng);
        marker[0] = new google.maps.Marker({
            position: myLatLng[0],
            map: map,
            icon: markerImage[0],
            shape: shape,
            title: loc[0].name,
            group_name: '',
            group_num: '',
            infoHtml: loc[0].html,
            zIndex: 99
        });
        //console.log(0);
        google.maps.event.addListener(marker[0], 'click', function() {
            infowindow[0] = new google.maps.InfoWindow();
            infowindow[0].open(map, this);
            infowindow[0].setContent(this.infoHtml);
        });
        bounds.extend(myLatLng[0]);
    }
}


function setMarkers() {
  
    // Markers and InfoWindows
    for (var i=1; i<=map_markers.length; i++) {
        loc[i] = map_markers[i-1];
        if (loc[i].group == '') loc[i].group = map_markers_groups[0];
        myLatLng[i] = new google.maps.LatLng(loc[i].lat, loc[i].lng);
        marker[i] = new google.maps.Marker({
            position: myLatLng[i],
            map: map,
            icon: markerImage[group_name_to_num[loc[i].group]],
            shape: shape,
            title: loc[i].name,
            group_name: loc[i].group,
            group_num: group_name_to_num[loc[i].group],
            infoHtml: loc[i].html,
            infoI: i,
            zIndex: 5
        });
        //console.log(marker[i].infoI);
        google.maps.event.addListener(marker[i], 'click', function() {
            if (typeof infowindow[this.infoI] != 'object') {
                infowindow[this.infoI] = new google.maps.InfoWindow();
            }
            infowindow[this.infoI].open(map, this);
            infowindow[this.infoI].setContent(this.infoHtml);
        });
        //console.log(marker[i]);
        bounds.extend(myLatLng[i]);
        markers.push(marker[i]);
    } // end for

}


function toggleMarkerGroupVisibility(group_num) {
    
    // Check markerGroupVisible
    visibility = markerGroupVisible[group_num];
    
    if (typeof group_num !== 'undefined' && group_num !== '') {
        // Markers
        var toggled = false;
        for (var i=0; i<=marker.length-1; i++) {
            if (typeof marker[i] === 'object') {
                if (marker[i].group_num == group_num) {
                    // Change Marker Visibility
                    marker[i].setVisible(!visibility);
                    toggled = true;
                }
            }
        }
        if (toggled === true) {
            markerGroupVisible[group_num] = !visibility;
            markerClusterer.repaint();
        }
    }
    
    return markerGroupVisible[group_num];
    
}


function setClusterControl() {

    // Controls for Clusters
    clusterControlDiv = document.createElement('div');
    // Set CSS styles for the DIV containing the control
    // Setting padding to 5 px will offset the control
    // from the edge of the map
    clusterControlDiv.style.padding = '6px';

    // Set CSS for the control border
    var controlUI = document.createElement('div');
    controlUI.style.backgroundColor = '#ffffff';
    controlUI.style.borderStyle = 'solid';
    controlUI.style.borderColor = '#a9a9a9';
    controlUI.style.borderWidth = '1px';
    controlUI.style.cursor = 'pointer';
    controlUI.style.textAlign = 'center';
    controlUI.title = 'Click to Toggle Clustering';
    clusterControlDiv.appendChild(controlUI);
    
    // Set CSS for the control interior
    var controlText = document.createElement('div');
    controlText.style.fontFamily = 'Arial,Verdana,Helvetica,sans-serif';
    controlText.style.fontSize = '12px';
    controlText.style.paddingLeft = '4px';
    controlText.style.paddingRight = '4px';
    controlText.style.paddingTop = '1px';
    controlText.style.paddingBottom = '1px';
    controlText.innerHTML = 'Toggle Clustering';
    controlUI.appendChild(controlText);

    clusterControlDiv.index = 1;
    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(clusterControlDiv);

    // http://google-maps-utility-library-v3.googlecode.com/svn/tags/markerclustererplus/2.1.1/examples/advanced_example.html?
    google.maps.event.addDomListener(controlUI, 'click', function() {
        if (markerClustererToggle !== true) {
            markerClusterer.setOptions({map:map});//restores the clusterIcons
            markerClustererToggle = true;
        } else {
            markerClusterer.setOptions({map:null});//hides the clusterIcons
            markerClustererToggle = false;
        }
        markerClusterer.repaint();
    });

}
    
    
function setCustomMarkers() {
    
    // Define the Custom Marker Images (jjwg_Markers Module)
    var customImage = [];
    for (var i=0; i<custom_markers_icons.length; i++) {
        image = custom_markers_icons[i];
        customImage[image] = new google.maps.MarkerImage(custom_markers_dir+image+'.png',
            new google.maps.Size(32,37),
            new google.maps.Point(0,0),
            new google.maps.Point(16,37)
        );
    }
    var custom_shape = {coord: [1, 1, 1, 37, 32, 37, 32, 1],type: 'poly'};

    for (var i=num_markers+1; i<=num_markers+num_custom_markers; i++) {
        
        loc[i] = custom_markers[i-num_markers-1];
        myLatLng[i] = new google.maps.LatLng(loc[i].lat, loc[i].lng);
        marker[i] = new google.maps.Marker({
            position: myLatLng[i],
            map: map,
            icon: customImage[loc[i].image],
            shape: custom_shape,
            title: loc[i].name,
            infoHtml: loc[i].html,
            infoI: i,
            zIndex: 25
        });
        //console.log(marker[i].infoI);
        google.maps.event.addListener(marker[i], 'click', function() {
            if (typeof infowindow[this.infoI] != 'object') {
                infowindow[this.infoI] = new google.maps.InfoWindow();
            }
            infowindow[this.infoI].open(map, this);
            infowindow[this.infoI].setContent(this.infoHtml);
        });
        bounds.extend(myLatLng[i]);
        markers.push(marker[i]);
        
    } // end for
    
}

function setCustomAreas() {

  // Define the Custom Area Polygons (jjwg_Areas Module)
    var polygon = [];
    var p = [];
    myAreaPolygon = [];
    
    for (var i=0; i<custom_areas.length; i++) {
        
        // coordinates: space separated lng,lat,elv points
        myCoords = [];
        polygon = custom_areas[i].coordinates.replace(/^[\s\n\r]+|[\s\n\r]+$/g,"").split(/[\n\r ]+/);
        for (var j=0; j<polygon.length; j++) {
            p = polygon[j].split(",");
            myCoords[j] = new google.maps.LatLng(parseFloat(p[1]), parseFloat(p[0])); // lat, lng
            bounds.extend(myCoords[j]);
        }
        myAreaPolygon[i] = new google.maps.Polygon({
            paths: myCoords,
            strokeColor: "#000099",
            strokeOpacity: 0.8,
            strokeWeight: 1,
            fillColor: "#000099",
            fillOpacity: 0.15,
            title: custom_areas[i].name,
            infoHtml: custom_areas[i].html,
            infoI: i+num_markers+num_custom_markers+1, // inc with markers counts
            zIndex: 1
        });
        //console.log(myAreaPolygon[i].infoI);
        myAreaPolygon[i].setMap(map);
        google.maps.event.addListener(myAreaPolygon[i], 'click', function(event) {
            if (typeof infowindow[this.infoI] != 'object') {
                infowindow[this.infoI] = new google.maps.InfoWindow();
            }
            infowindow[this.infoI].setContent(this.infoHtml);
            infowindow[this.infoI].setPosition(event.latLng);
            infowindow[this.infoI].open(map);
        });
    }

  }



function initialize() {

    map = new google.maps.Map(document.getElementById("map_canvas"), {
        zoom: 4,
        center: new google.maps.LatLng(
            jjwg_config['map_default_center_latitude'], jjwg_config['map_default_center_longitude']
        ),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    bounds = new google.maps.LatLngBounds();
    
    // Define the Marker Images
    for (var i=0; i<=map_markers_groups.length; i++) {
        markerImage[i] = new google.maps.MarkerImage(icons_dir+'/marker_'+i+'.png',
        new google.maps.Size(20,34), new google.maps.Point(0,0), new google.maps.Point(10,34));
        // Set initial visibility toggle to true for legend groups
        markerGroupVisible[group_name_to_num[map_markers_groups[i]]] = true;
        //markerGroupVisible[i] = true;
    }
    shape = {coord: [1, 1, 1, 34, 20, 34, 20, 1],type: 'poly'};
    
    setCenterMarker();
    setMarkers();
    setCustomMarkers();
    setCustomAreas();
    
    // Position Legend
    legend = document.getElementById('legend');
    map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);
    
    // Now using MarkerClustererPlus v2.1.1
    markerClusterer = new MarkerClusterer(map, markers, {
        maxZoom: (typeof jjwg_config['map_clusterer_max_zoom'] === 'undefined') ? jjwg_config_defaults['map_clusterer_max_zoom'] : jjwg_config['map_clusterer_max_zoom'],
        gridSize: (typeof jjwg_config['map_clusterer_grid_size'] === 'undefined') ? jjwg_config_defaults['map_clusterer_max_zoom'] : jjwg_config['map_clusterer_grid_size'],
        ignoreHidden: true
    });
    markerClustererToggle = true;
    setClusterControl();

  // Set a maximum zoom Level only on initial zoom
  map.fitBounds(bounds);
  google.maps.event.addListenerOnce(map, "idle", function() { 
    if (map.getZoom() > 15) map.setZoom(15);
  });

}





<?php
  if ($num_markers > 0) {
?>
  // Define DataTable Data
  $(document).ready(function(){
    
    var oDataTable = $('#displayDataTable').dataTable({
        "bPaginate": true,
        "bFilter": true,
        "bStateSave": true,
        "bProcessing": true,
        "oLanguage": { "sUrl": "modules/jjwg_Maps/DataTables/media/language/<?php echo $GLOBALS['current_language']; ?>.lang.txt" },
        "aaData": map_markers,
        "aoColumns": [
            {
                "sWidth": "30%", 
                "mDataProp": "name",
                "mRender": function (data, type, row) {
                    if (type == 'display') {
                        return '<a target="_blank" href="./index.php?module=' + row.module + 
                            '&amp;action=DetailView&amp;record=' + row.id + 
                            '" class="link target_blank">' + data + '</a>';
                    } else {
                        return data;
                    }
                }
            },
            { "mData": "address" },
            { "mData": "assigned_user_name" },
            {
                "sWidth": "8%",
                "mDataProp": "group",
                "mRender": function (data, type, row) {
                    if (data !== null && data !== '') {
                        return data;
                    } else {
                        return "{"+mod_strings['LBL_MAP_NULL_GROUP_NAME']+"}";
                    }
                }
            },
            {
                "sWidth": "7%",
                "mDataProp": "module",
                "mRender": function (data, type, row) {
                    if (app_list_strings['moduleListSingular'][data] !== '') {
                        return app_list_strings['moduleListSingular'][data];
                    } else {
                        return data;
                    }
                }
            }
        ]
    });
    
    // Toogle Marker Group Visibility on Click of Image
    $('#legend img').click(function(){
        var rel_group_num = $(this).attr('rel');
        visibile_result = toggleMarkerGroupVisibility(rel_group_num);
        if (!visibile_result) {
            $(this).css({ opacity: 0.55 });
        } else {
            $(this).css({ opacity: 1.0 });
        }
        
  });
    
    
  });
<?php
  }
?>

</script>

</head>

<body onload="initialize()">
  
  <div id="map_canvas"></div>
  
  <br clear="all" />
  
<?php
  if (!empty($GLOBALS['map_center']) || $num_markers > 0) {
?>
  <div id="legend">
  <b><?php echo $GLOBALS['mod_strings']['LBL_MAP_LEGEND']; ?></b><br/>
<?php
  if (!empty($GLOBALS['map_center'])) {
?>
    <img src="<?php echo $GLOBALS['sugar_config']['site_url'].'/'.$icons_dir.'/marker_0.png'; ?>" align="middle" />
    <?php echo $GLOBALS['map_center']['name']; ?><br/>
<?php
  }
?>
  <!-- <b><?php echo $GLOBALS['mod_strings']['LBL_MAP_USER_GROUPS']; ?> </b><br/> -->
<?php
  foreach($group_name_to_num as $group_name => $group_number) {
?>
    <img src="<?php echo $GLOBALS['sugar_config']['site_url'].'/'.$icons_dir.'/marker_'.$group_number.'.png'; ?>" 
         rel="<?php echo $group_number; ?>" align="middle" />
<?php
    if (empty($group_name)) {
        echo '{'.$GLOBALS['mod_strings']['LBL_MAP_NULL_GROUP_NAME'].'}';
    } else {
        echo htmlentities($group_name, ENT_COMPAT, "UTF-8", false);
    }
    ?><br/>
<?php
  }
?>   
  </div>
<?php
  }
?>
  
<?php
  if ($num_markers > 0) {
?>
    <div id="DataTable">
        <table cellpadding="3" cellspacing="0" border="1" width="100%" class="list view" id="displayDataTable">
            <thead>
                <tr>
                    <th width="30%" scope="col"><?php echo $GLOBALS['mod_strings']['LBL_NAME']; ?></th>
                    <th width="35%" scope="col"><?php echo $GLOBALS['mod_strings']['LBL_MAP_ADDRESS']; ?></th>
                    <th width="15%" scope="col"><?php echo $GLOBALS['mod_strings']['LBL_ASSIGNED_TO_NAME']; ?></th>
                    <th width="8%" scope="col"><?php echo $GLOBALS['mod_strings']['LBL_MAP_GROUP']; ?></th>
                    <th width="7%" scope="col"><?php echo $GLOBALS['mod_strings']['LBL_MAP_TYPE']; ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
<?php
  }
?>

<?php
// Testing Dump
//echo "<pre>";
//var_dump($this);
//var_dump($GLOBALS['current_language']);
//var_dump($GLOBALS['dictionary']);
//var_dump($GLOBALS['app_list_strings']);
//var_dump($GLOBALS['app_strings']);
//var_dump($GLOBALS['mod_strings']);
//echo "</pre>";
?>
  
</body> 
</html>
<?php

   }
}
