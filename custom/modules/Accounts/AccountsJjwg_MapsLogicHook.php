<?php
// custom/modules/Accounts/AccountsJjwg_MapsLogicHook.php

// before_save

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class AccountsJjwg_MapsLogicHook {

	function removeGeocodeInfo(&$bean, $event, $arguments) {
		
		// If the address has changed in any way then reset the geocode values
		//echo "<pre>";
		
		if ($bean->fetched_row['billing_address_street'] != $bean->billing_address_street || 
			$bean->fetched_row['billing_address_city'] != $bean->billing_address_city || 
			$bean->fetched_row['billing_address_state'] != $bean->billing_address_state || 
			$bean->fetched_row['billing_address_postalcode'] != $bean->billing_address_postalcode || 
			$bean->fetched_row['billing_address_country'] != $bean->billing_address_country || 
			$bean->fetched_row['billing_address_street'] != $bean->billing_address_street
			) {
			
			// Reset the geocode fields
			$bean->jjwg_maps_lat_c = 0;
			$bean->jjwg_maps_lng_c = 0;
			$bean->jjwg_maps_geocode_status_c = '';
			$bean->jjwg_maps_address_c = '';
			
			// These objects don't have an addresss and rely on the account address
            require_once('modules/Opportunities/Opportunity.php');
            require_once('modules/Cases/Case.php');
            require_once('modules/Project/Project.php');
			
			// Find related opportunities and reset geocode
            $relOpportunities = $bean->get_linked_beans('opportunities', 'Opportunity');
			if ($relOpportunities) {
	            foreach ($relOpportunities as $relOpportunity) {
	            	echo $relOpportunity->name."\n\n";
					$relOpportunity->jjwg_maps_lat_c = 0;
					$relOpportunity->jjwg_maps_lng_c = 0;
					$relOpportunity->jjwg_maps_geocode_status_c = '';
					$relOpportunity->jjwg_maps_address_c = '';
					$relOpportunity->save(FALSE);
				}
			}
			// Find related cases and reset geocode
            $relCases = $bean->get_linked_beans('cases', 'aCase');
			if ($relCases) {
	            foreach ($relCases as $relCase) {
	            	echo $relCase->name."\n\n";
					$relCase->jjwg_maps_lat_c = 0;
					$relCase->jjwg_maps_lng_c = 0;
					$relCase->jjwg_maps_geocode_status_c = '';
					$relOpportunity->jjwg_maps_address_c = '';
					$relCase->save(FALSE);
				}
			}
			// Find related projects and reset geocode
            $relProjects = $bean->get_linked_beans('project', 'Project');
			if ($relProjects) {
	            foreach ($relProjects as $relProject) {
	            	echo $relProject->name."\n\n";
					$relProject->jjwg_maps_lat_c = 0;
					$relProject->jjwg_maps_lng_c = 0;
					$relProject->jjwg_maps_geocode_status_c = '';
					$relOpportunity->jjwg_maps_address_c = '';
					$relProject->save(FALSE);
				}
			}
			
		}
		
		//exit;
					
	} // end
	
}

?>