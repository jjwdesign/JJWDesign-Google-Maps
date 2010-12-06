<?php
// custom/modules/Contacts/ContactsJjwg_MapsLogicHook.php

// before_save

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class ContactsJjwg_MapsLogicHook {

	function removeGeocodeInfo(&$bean, $event, $arguments) {
		
		// If the address has changed in any way then reset the geocode values
		
		if ($bean->fetched_row['primary_address_street'] != $bean->primary_address_street || 
			$bean->fetched_row['primary_address_city'] != $bean->primary_address_city || 
			$bean->fetched_row['primary_address_state'] != $bean->primary_address_state || 
			$bean->fetched_row['primary_address_postalcode'] != $bean->primary_address_postalcode || 
			$bean->fetched_row['primary_address_country'] != $bean->primary_address_country || 
			$bean->fetched_row['primary_address_street'] != $bean->primary_address_street
			) {
			
			// Reset the geocode fields
			$bean->jjwg_maps_lat_c = 0;
			$bean->jjwg_maps_lng_c = 0;
			$bean->jjwg_maps_geocode_status_c = '';
			$bean->jjwg_maps_address_c = '';

		}
	
	} // end

}

?>