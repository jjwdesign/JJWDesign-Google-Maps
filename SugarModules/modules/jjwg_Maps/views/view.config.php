<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class Jjwg_MapsViewConfig extends SugarView {

    function Jjwg_MapsViewConfig() {
        parent::SugarView();
    }

    function display() {

        global $sugar_config;
        global $jjwg_config_defaults;
        global $jjwg_config;
        
        global $currentModule;
        global $current_user;
        global $valid_geocode_modules;
        global $theme;
        global $mod_strings;
        global $app_strings;
        global $app_list_strings;

        // Language Needed!
        
        // Language Arrays
        $address_types_billing_or_shipping = array(
            'billing' => 'Billing Address',
            'shipping' => 'Shipping Address',
        );
        $address_types_primary_or_alt = array(
            'primary' => 'Primary Address',
            'alt' => 'Alternative Address',
        );
        $address_types_flex_relate = array(
            'flex_relate' => 'Flex Relate'
        );
        $address_cache_enabled_disabled = array(
            '0' => 'Disabled',
            '1' => 'Enabled'
        );
        
        $unit_types = $app_list_strings['map_unit_type_list'];
        ?>

        <p style="margin: 15px 0px 15px 0px; font-size: 1.7em;"><strong>Please consider donating to this project!</strong></p>

        <p style="margin: 15px 0px 15px 0px; font-size: 1.25em; width: 790px;">
            If you've found this project helpful, please donate!<br />
            Donations from users like you will help keep this project alive.
        </p>
        
        <div style="margin: 15px 0px 15px 0px;">
            <span style="font-size: 1.7em;"><strong>$5, $20, $100 or even $500 &nbsp;</strong></span>
            <form style="display:inline;" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                <input type="hidden" name="cmd" value="_s-xclick">
                <input type="hidden" name="hosted_button_id" value="FZENX6PLHKX2L">
                <input style="border:0;" type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
            </form>
        </div>
        
        <p>&nbsp;</p>

        <p style="margin: 15px 0px 15px 0px; font-size: 1.7em;"><strong>Configuration Settings</strong></p>

        <?php if (!empty($_REQUEST['config_save_notice'])) { ?>
            <p style="margin: 15px 0px 15px 0px; font-size: 1.5em;"><strong>Settings Saved Successfully</strong></p>
        <?php } ?>

<form name="settings" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" name="module" value="<?php echo $currentModule; ?>">
<input type="hidden" name="action" value="config" />

<table class="edit view" cellpadding="0" cellspacing="12" border="0">
    <tr>
        <td colspan="2">
            <strong>Address Type:</strong> This defines the modules' address types used when geocoding addresses.<br />
            Acceptable Values: 'billing', 'shipping', 'primary', 'alt', 'flex_relate'<br />
        </td>
    </tr>
    <tr>
        <td width="20%" nowrap="nowrap">
            <strong><?php echo 'Address Type for Accounts:'; ?> </strong>
        </td>
        <td>
            <select id="address_type_Accounts" tabindex="111" 
                name="address_type_Accounts" title="">
                <?php foreach ($address_types_billing_or_shipping as $key=>$value) { ?>
                    <option value="<?php echo htmlspecialchars($key); ?>" <?php 
                    if ($key == $jjwg_config['geocode_modules_to_address_type']['Accounts']) echo 'selected="selected"';
                    ?>><?php echo htmlspecialchars($value); ?>
                <? } ?>
            </select>
            &nbsp; Default: <?php echo htmlspecialchars($address_types_billing_or_shipping[$jjwg_config_defaults['geocode_modules_to_address_type']['Accounts']]); ?>
        </td>
    </tr>
    <tr>
        <td>
            <strong><?php echo 'Address Type for Contacts:'; ?> </strong>
        </td>
        <td>
            <select id="address_type_Contacts" tabindex="112" 
                name="address_type_Contacts" title="">
                <?php foreach ($address_types_primary_or_alt as $key=>$value) { ?>
                    <option value="<?php echo htmlspecialchars($key); ?>" <?php 
                    if ($key == $jjwg_config['geocode_modules_to_address_type']['Contacts']) echo 'selected="selected"';
                    ?>><?php echo htmlspecialchars($value); ?>
                <? } ?>
            </select>
            &nbsp; Default: <?php echo htmlspecialchars($address_types_primary_or_alt[$jjwg_config_defaults['geocode_modules_to_address_type']['Contacts']]); ?>
        </td>
    </tr>
    <tr>
        <td>
            <strong><?php echo 'Address Type for Leads:'; ?> </strong>
        </td>
        <td>
            <select id="address_type_Leads" tabindex="113" 
                name="address_type_Leads" title="">
                <?php foreach ($address_types_primary_or_alt as $key=>$value) { ?>
                    <option value="<?php echo htmlspecialchars($key); ?>" <?php 
                    if ($key == $jjwg_config['geocode_modules_to_address_type']['Leads']) echo 'selected="selected"';
                    ?>><?php echo htmlspecialchars($value); ?>
                <? } ?>
            </select>
            &nbsp; Default: <?php echo htmlspecialchars($address_types_primary_or_alt[$jjwg_config_defaults['geocode_modules_to_address_type']['Leads']]); ?>
        </td>
    </tr>
    <tr>
        <td>
            <strong><?php echo 'Address Type for Opportunities:'; ?> </strong>
        </td>
        <td>
            <select id="address_type_Opportunities" tabindex="114" 
                name="address_type_Opportunities" title="">
                <?php foreach ($address_types_billing_or_shipping as $key=>$value) { ?>
                    <option value="<?php echo htmlspecialchars($key); ?>" <?php 
                    if ($key == $jjwg_config['geocode_modules_to_address_type']['Opportunities']) echo 'selected="selected"';
                    ?>><?php echo htmlspecialchars($value); ?>
                <? } ?>
            </select>
            &nbsp; Default: <?php echo htmlspecialchars($address_types_billing_or_shipping[$jjwg_config_defaults['geocode_modules_to_address_type']['Opportunities']]); ?> of Related Account
        </td>
    </tr>
    <tr>
        <td>
            <strong><?php echo 'Address Type for Cases:'; ?> </strong>
        </td>
        <td>
            <select id="address_type_Cases" tabindex="115" 
                name="address_type_Cases" title="">
                <?php foreach ($address_types_billing_or_shipping as $key=>$value) { ?>
                    <option value="<?php echo htmlspecialchars($key); ?>" <?php 
                    if ($key == $jjwg_config['geocode_modules_to_address_type']['Cases']) echo 'selected="selected"';
                    ?>><?php echo htmlspecialchars($value); ?>
                <? } ?>
            </select>
            &nbsp; Default: <?php echo htmlspecialchars($address_types_billing_or_shipping[$jjwg_config_defaults['geocode_modules_to_address_type']['Cases']]); ?> of Related Account
        </td>
    </tr>
    <tr>
        <td>
            <strong><?php echo 'Address Type for Projects:'; ?> </strong>
        </td>
        <td>
            <select id="address_type_Project" tabindex="116" 
                name="address_type_Project" title="">
                <?php foreach ($address_types_billing_or_shipping as $key=>$value) { ?>
                    <option value="<?php echo htmlspecialchars($key); ?>" <?php 
                    if ($key == $jjwg_config['geocode_modules_to_address_type']['Project']) echo 'selected="selected"';
                    ?>><?php echo htmlspecialchars($value); ?>
                <? } ?>
            </select>
            &nbsp; Default: <?php echo htmlspecialchars($address_types_billing_or_shipping[$jjwg_config_defaults['geocode_modules_to_address_type']['Project']]); ?> of Related Account/Opportunity
        </td>
    </tr>
    <tr>
        <td>
            <strong><?php echo 'Address Type for Meetings:'; ?> </strong>
        </td>
        <td>
            <select id="address_type_Meetings" tabindex="117" 
                name="address_type_Meetings" title="">
                <?php foreach ($address_types_flex_relate as $key=>$value) { ?>
                    <option value="<?php echo htmlspecialchars($key); ?>" <?php 
                    if ($key == $jjwg_config['geocode_modules_to_address_type']['Meetings']) echo 'selected="selected"';
                    ?>><?php echo htmlspecialchars($value); ?>
                <? } ?>
            </select>
            &nbsp; Related Object thru Flex Relate Field
        </td>
    </tr>
    <tr>
        <td width="20%" nowrap="nowrap">
            <strong><?php echo 'Address Type for Prospects/Targets:'; ?> </strong>
        </td>
        <td>
            <select id="address_type_Prospects" tabindex="118" 
                name="address_type_Prospects" title="">
                <?php foreach ($address_types_primary_or_alt as $key=>$value) { ?>
                    <option value="<?php echo htmlspecialchars($key); ?>" <?php 
                    if ($key == $jjwg_config['geocode_modules_to_address_type']['Prospects']) echo 'selected="selected"';
                    ?>><?php echo htmlspecialchars($value); ?>
                <? } ?>
            </select>
            &nbsp; Default: <?php echo htmlspecialchars($address_types_primary_or_alt[$jjwg_config_defaults['geocode_modules_to_address_type']['Prospects']]); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    
    
    <tr>
        <td colspan="2">
            <strong>Marker Group Field Settings:</strong> This defines the 'field' to be used as the group parameter when displaying markers on a map.<br />
            Examples: assigned_user_name, industry, status, sales_stage, priority<br />
        </td>
    </tr>
    <tr>
        <td><strong><?php echo 'Group Field for Accounts:'; ?> </strong></td>
        <td><input type="text" name="grouping_field_Accounts" id="grouping_field_Accounts" 
            value="<?php echo (isset($jjwg_config['map_markers_grouping_field']['Accounts'])) ? 
                htmlspecialchars($jjwg_config['map_markers_grouping_field']['Accounts']) : 
                htmlspecialchars($jjwg_config_defaults['map_markers_grouping_field']['Accounts']); ?>" 
            title='' tabindex='121' size="25" maxlength="75">
            &nbsp; Default: <?php echo htmlspecialchars($jjwg_config_defaults['map_markers_grouping_field']['Accounts']); ?>
        </td>
    </tr>
    <tr>
        <td><strong><?php echo 'Group Field for Contacts:'; ?> </strong></td>
        <td><input type="text" name="grouping_field_Contacts" id="grouping_field_Contacts" 
            value="<?php echo (isset($jjwg_config['map_markers_grouping_field']['Contacts'])) ? 
                htmlspecialchars($jjwg_config['map_markers_grouping_field']['Contacts']) : 
                htmlspecialchars($jjwg_config_defaults['map_markers_grouping_field']['Contacts']); ?>" 
            title='' tabindex='122' size="25" maxlength="32">
            &nbsp; Default: <?php echo htmlspecialchars($jjwg_config_defaults['map_markers_grouping_field']['Contacts']); ?>
        </td>
    </tr>
    <tr>
        <td><strong><?php echo 'Group Field for Leads:'; ?> </strong></td>
        <td><input type="text" name="grouping_field_Leads" id="grouping_field_Leads" 
            value="<?php echo (isset($jjwg_config['map_markers_grouping_field']['Leads'])) ? 
                htmlspecialchars($jjwg_config['map_markers_grouping_field']['Leads']) : 
                htmlspecialchars($jjwg_config_defaults['map_markers_grouping_field']['Leads']); ?>" 
            title='' tabindex='123' size="25" maxlength="32">
            &nbsp; Default: <?php echo htmlspecialchars($jjwg_config_defaults['map_markers_grouping_field']['Leads']); ?>
        </td>
    </tr>
    <tr>
        <td><strong><?php echo 'Group Field for Opportunities:'; ?> </strong></td>
        <td><input type="text" name="grouping_field_Opportunities" id="grouping_field_Opportunities" 
            value="<?php echo (isset($jjwg_config['map_markers_grouping_field']['Opportunities'])) ? 
                htmlspecialchars($jjwg_config['map_markers_grouping_field']['Opportunities']) : 
                htmlspecialchars($jjwg_config_defaults['map_markers_grouping_field']['Opportunities']); ?>" 
            title='' tabindex='124' size="25" maxlength="32">
            &nbsp; Default: <?php echo htmlspecialchars($jjwg_config_defaults['map_markers_grouping_field']['Opportunities']); ?>
        </td>
    </tr>
    <tr>
        <td><strong><?php echo 'Group Field for Cases:'; ?> </strong></td>
        <td><input type="text" name="grouping_field_Cases" id="grouping_field_Cases" 
            value="<?php echo (isset($jjwg_config['map_markers_grouping_field']['Cases'])) ? 
                htmlspecialchars($jjwg_config['map_markers_grouping_field']['Cases']) : 
                htmlspecialchars($jjwg_config_defaults['map_markers_grouping_field']['Cases']); ?>" 
            title='' tabindex='125' size="25" maxlength="32">
            &nbsp; Default: <?php echo htmlspecialchars($jjwg_config_defaults['map_markers_grouping_field']['Cases']); ?>
        </td>
    </tr>
    <tr>
        <td><strong><?php echo 'Group Field for Projects:'; ?> </strong></td>
        <td><input type="text" name="grouping_field_Project" id="grouping_field_Project" 
            value="<?php echo (isset($jjwg_config['map_markers_grouping_field']['Project'])) ? 
                htmlspecialchars($jjwg_config['map_markers_grouping_field']['Project']) : 
                htmlspecialchars($jjwg_config_defaults['map_markers_grouping_field']['Project']); ?>" 
            title='' tabindex='126' size="25" maxlength="32">
            &nbsp; Default: <?php echo htmlspecialchars($jjwg_config_defaults['map_markers_grouping_field']['Project']); ?>
        </td>
    </tr>
    <tr>
        <td><strong><?php echo 'Group Field for Meetings:'; ?> </strong></td>
        <td><input type="text" name="grouping_field_Meetings" id="grouping_field_Meetings" 
            value="<?php echo (isset($jjwg_config['map_markers_grouping_field']['Meetings'])) ? 
                htmlspecialchars($jjwg_config['map_markers_grouping_field']['Meetings']) : 
                htmlspecialchars($jjwg_config_defaults['map_markers_grouping_field']['Meetings']); ?>" 
            title='' tabindex='127' size="25" maxlength="32">
            &nbsp; Default: <?php echo htmlspecialchars($jjwg_config_defaults['map_markers_grouping_field']['Meetings']); ?>
            &nbsp; (Limited to Meetings Module Fields)
        </td>
    </tr>
    <tr>
        <td><strong><?php echo 'Group Field for Prospects/Targets:'; ?> </strong></td>
        <td><input type="text" name="grouping_field_Prospects" id="grouping_field_Prospects" 
            value="<?php echo (isset($jjwg_config['map_markers_grouping_field']['Prospects'])) ? 
                htmlspecialchars($jjwg_config['map_markers_grouping_field']['Prospects']) : 
                htmlspecialchars($jjwg_config_defaults['map_markers_grouping_field']['Prospects']); ?>" 
            title='' tabindex='128' size="25" maxlength="32">
            &nbsp; Default: <?php echo htmlspecialchars($jjwg_config_defaults['map_markers_grouping_field']['Prospects']); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>

    <tr>
        <td colspan="2">
            <strong>Geocoding/Google Settings:</strong>
        </td>
    </tr>
    <tr>
        <td><strong><?php echo 'Geocoding Limit:'; ?> </strong></td>
        <td><input type="text" name="geocoding_limit" id="geocoding_limit" 
            value="<?php echo (isset($jjwg_config['geocoding_limit'])) ? 
                htmlspecialchars($jjwg_config['geocoding_limit']) : 
                htmlspecialchars($jjwg_config_defaults['geocoding_limit']); ?>" 
            title='' tabindex='141' size="10" maxlength="25">
            &nbsp; Default: <?php echo htmlspecialchars($jjwg_config_defaults['geocoding_limit']) ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">'geocoding_limit' sets the query limit when selecting records to geocode.</td>
    </tr>
    <tr>
        <td><strong><?php echo 'Google Geocoding Limit:'; ?> </strong></td>
        <td><input type="text" name="google_geocoding_limit" id="google_geocoding_limit" 
            value="<?php echo (isset($jjwg_config['google_geocoding_limit'])) ? 
                htmlspecialchars($jjwg_config['google_geocoding_limit']) : 
                htmlspecialchars($jjwg_config_defaults['google_geocoding_limit']); ?>" 
            title='' tabindex='142' size="10" maxlength="25">
            &nbsp; Default: <?php echo htmlspecialchars($jjwg_config_defaults['google_geocoding_limit']) ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">'google_geocoding_limit' sets the request limit when geocoding using the Google Maps API.</td>
    </tr>
    <tr>
        <td><strong><?php echo 'Export Addresses Limit:'; ?> </strong></td>
        <td><input type="text" name="export_addresses_limit" id="export_addresses_limit" 
            value="<?php echo (isset($jjwg_config['export_addresses_limit'])) ? 
                htmlspecialchars($jjwg_config['export_addresses_limit']) : 
                htmlspecialchars($jjwg_config_defaults['export_addresses_limit']); ?>" 
            title='' tabindex='143' size="10" maxlength="25">
            &nbsp; Default: <?php echo htmlspecialchars($jjwg_config_defaults['export_addresses_limit']) ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">'export_addresses_limit' sets the query limit when selecting records to export.</td>
    </tr>



    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>

    <tr>
        <td colspan="2">
            <strong>Address Cache Settings:</strong>
        </td>
    </tr>
    <tr>
        <td><strong><?php echo 'Enable Address Cache (Get):'; ?> </strong></td>
        <td>
            <?php $enabled = !empty($jjwg_config['address_cache_get_enabled']) ? '1' : '0'; ?>
            <select id="address_cache_get_enabled" tabindex="145" 
                name="address_cache_get_enabled" title="">
                <?php foreach ($address_cache_enabled_disabled as $key=>$value) { ?>
                    <option value="<?php echo htmlspecialchars($key); ?>" <?php 
                    if ($key == $enabled) echo 'selected="selected"';
                    ?>><?php echo htmlspecialchars($value); ?>
                <? } ?>
            </select>
            &nbsp; Default: <?php echo htmlspecialchars($address_cache_enabled_disabled[$jjwg_config_defaults['address_cache_get_enabled']]) ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">'address_cache_get_enabled' allows the address cache module to retrieve data from the cache table.</td>
    </tr>
    <tr>
        <td><strong><?php echo 'Enable Saving Address Cache (Save):'; ?> </strong></td>
        <td>
            <?php $enabled = !empty($jjwg_config['address_cache_save_enabled']) ? '1' : '0'; ?>
            <select id="address_cache_save_enabled" tabindex="146" 
                name="address_cache_save_enabled" title="">
                <?php foreach ($address_cache_enabled_disabled as $key=>$value) { ?>
                    <option value="<?php echo htmlspecialchars($key); ?>" <?php 
                    if ($key == $enabled) echo 'selected="selected"';
                    ?>><?php echo htmlspecialchars($value); ?>
                <? } ?>
            </select>
            &nbsp; Default: <?php echo htmlspecialchars($address_cache_enabled_disabled[$jjwg_config_defaults['address_cache_save_enabled']]) ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">'address_cache_save_enabled' allows the address cache module to save data to the cache table.</td>
    </tr>

    
    
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>

    <tr>
        <td colspan="2">
            <strong>Marker/Mapping Settings:</strong>
        </td>
    </tr>
    <tr>
        <td><strong><?php echo 'Map Markers Limit:'; ?> </strong></td>
        <td><input type="text" name="map_markers_limit" id="map_markers_limit" 
            value="<?php echo (isset($jjwg_config['map_markers_limit'])) ? 
                htmlspecialchars($jjwg_config['map_markers_limit']) : 
                htmlspecialchars($jjwg_config_defaults['map_markers_limit']); ?>" 
            title='' tabindex='150' size="10" maxlength="25">
            &nbsp; Default: <?php echo htmlspecialchars($jjwg_config_defaults['map_markers_limit']) ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">'map_markers_limit' sets the query limit when selecting records to display on a map.</td>
    </tr>
    <tr>
        <td><strong><?php echo 'Map Default Center Latitude:'; ?> </strong></td>
        <td><input type="text" name="map_default_center_latitude" id="map_default_center_latitude" 
            value="<?php echo (isset($jjwg_config['map_default_center_latitude'])) ? 
                htmlspecialchars($jjwg_config['map_default_center_latitude']) : 
                htmlspecialchars($jjwg_config_defaults['map_default_center_latitude']); ?>" 
            title='' tabindex='151' size="10" maxlength="25">
            &nbsp; Default: <?php echo htmlspecialchars($jjwg_config_defaults['map_default_center_latitude']) ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">'map_default_center_latitude' sets the default center latitude position for maps.</td>
    </tr>
    <tr>
        <td><strong><?php echo 'Map Default Center Longitude:'; ?> </strong></td>
        <td><input type="text" name="map_default_center_longitude" id="map_default_center_longitude" 
            value="<?php echo (isset($jjwg_config['map_default_center_longitude'])) ? 
                htmlspecialchars($jjwg_config['map_default_center_longitude']) : 
                htmlspecialchars($jjwg_config_defaults['map_default_center_longitude']); ?>" 
            title='' tabindex='152' size="10" maxlength="25">
            &nbsp; Default: <?php echo htmlspecialchars($jjwg_config_defaults['map_default_center_longitude']) ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">'map_default_center_longitude' sets the default center longitude position for maps.</td>
    </tr>
    <tr>
        <td><strong><?php echo 'Map Default Unit Type:'; ?> </strong></td>
        <td>
            <select id="map_default_unit_type" tabindex="153" 
                name="map_default_unit_type" title="">
                <?php foreach ($unit_types as $key=>$value) { ?>
                    <option value="<?php echo htmlspecialchars($key); ?>" <?php 
                    if ($key == $jjwg_config['map_default_unit_type']) echo 'selected="selected"';
                    ?>><?php echo htmlspecialchars($value); ?>
                <? } ?>
            </select>
            &nbsp; Default: <?php echo htmlspecialchars($jjwg_config_defaults['map_default_unit_type']) ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">map_default_unit_type' sets the default unit measurement type for distance calculations. Values: 'mi' (miles) or 'km' (kilometers).</td>
    </tr>
    <tr>
        <td><strong><?php echo 'Map Default Distance:'; ?> </strong></td>
        <td><input type="text" name="map_default_distance" id="map_default_distance" 
            value="<?php echo (isset($jjwg_config['map_default_distance'])) ? 
                htmlspecialchars($jjwg_config['map_default_distance']) : 
                htmlspecialchars($jjwg_config_defaults['map_default_distance']); ?>" 
            title='' tabindex='154' size="10" maxlength="25">
            &nbsp; Default: <?php echo htmlspecialchars($jjwg_config_defaults['map_default_distance']) ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">'map_default_distance' sets the default distance used for distance based maps.</td>
    </tr>
    <tr>
        <td><strong><?php echo 'Map Duplicate Marker Adjustment:'; ?> </strong></td>
        <td><input type="text" name="map_duplicate_marker_adjustment" id="map_duplicate_marker_adjustment" 
            value="<?php echo (isset($jjwg_config['map_duplicate_marker_adjustment'])) ? 
                rtrim(number_format($jjwg_config['map_duplicate_marker_adjustment'], 8), '0.') : 
                rtrim(number_format($jjwg_config_defaults['map_duplicate_marker_adjustment'], 8), '0.'); ?>" 
            title='' tabindex='155' size="10" maxlength="25">
            &nbsp; Default: <?php echo rtrim(number_format($jjwg_config_defaults['map_duplicate_marker_adjustment'], 8), '0.'); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">'map_duplicate_marker_adjustment' sets an offset adjustment to be added to longitude and latitude in case of duplicate marker position.</td>
    </tr>
    <tr>
        <td><strong><?php echo 'Map Markers Clusterer Grid Size:'; ?> </strong></td>
        <td><input type="text" name="map_clusterer_grid_size" id="map_clusterer_grid_size" 
            value="<?php echo (isset($jjwg_config['map_clusterer_grid_size'])) ? 
                htmlspecialchars($jjwg_config['map_clusterer_grid_size']) : 
                htmlspecialchars($jjwg_config_defaults['map_clusterer_grid_size']); ?>" 
            title='' tabindex='156' size="10" maxlength="25">
            &nbsp; Default: <?php echo htmlspecialchars($jjwg_config_defaults['map_clusterer_grid_size']) ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">'map_clusterer_grid_size' is used to set the grid size for calculating map clusterers.</td>
    </tr>
    <tr>
        <td><strong><?php echo 'Map Markers Clusterer Max Zoom:'; ?> </strong></td>
        <td><input type="text" name="map_clusterer_max_zoom" id="map_clusterer_max_zoom" 
            value="<?php echo (isset($jjwg_config['map_clusterer_max_zoom'])) ? 
                htmlspecialchars($jjwg_config['map_clusterer_max_zoom']) : 
                htmlspecialchars($jjwg_config_defaults['map_clusterer_max_zoom']); ?>" 
            title='' tabindex='157' size="10" maxlength="25">
            &nbsp; Default: <?php echo htmlspecialchars($jjwg_config_defaults['map_clusterer_max_zoom']) ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">'map_clusterer_max_zoom' is used to set the maximum zoom level at which clustering will not be applied.</td>
    </tr>
</table>

<br />

<input type="submit" class="button" tabindex="211" name="submit" value="  <?php echo $app_strings['LBL_SAVE_BUTTON_LABEL']; ?>  " align="bottom">
&nbsp;
<input type="button" class="button" tabindex="212" name="cancel" value="  <?php echo $app_strings['LBL_CANCEL_BUTTON_LABEL']; ?>  " align="bottom"
        onclick="document.location.href='index.php?module=Administration&amp;action=index'" title="">

</form>

     
        <p style="margin: 25px 0px 15px 0px; font-size: 1em; width: 700px;">
            All saved settings can be found in the 'config' table under category 'jjwg'.<br />
            Note, a custom controller.php file should no longer be used to override settings.
        </p>
        
        <p>&nbsp;</p>
        <br />
        
<pre>
<?php
//var_dump($sugar_config);
//var_dump($jjwg_config_defaults);
//var_dump($jjwg_config);
//var_dump($current_user);
//var_dump($mod_strings);
//var_dump($app_strings);
//var_dump($app_list_strings);
?>
</pre>

        <?php

    }

}
?>