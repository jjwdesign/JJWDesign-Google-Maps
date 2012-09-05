<?php

function post_uninstall() {

  // Uncomment this section of code if you wish to remove custom fields.

  /*
  // Cleanup any remaining custom fields
  global $db;

  $query = "DELETE FROM fields_meta_data WHERE name LIKE 'jjwg_maps%';";
  $db->query($query, false);

  $query = "DELETE FROM fields_meta_data WHERE id LIKE 'jjwg_Maps%';";
  $db->query($query, false);

  $query = "ALTER TABLE accounts_cstm DROP jjwg_maps_lng_c;";
  $db->query($query, false);
  $query = "ALTER TABLE accounts_cstm DROP jjwg_maps_lat_c;";
  $db->query($query, false);
  $query = "ALTER TABLE accounts_cstm DROP jjwg_maps_geocode_status_c;";
  $db->query($query, false);
  $query = "ALTER TABLE accounts_cstm DROP jjwg_maps_address_c;";
  $db->query($query, false);

  $query = "ALTER TABLE cases_cstm DROP jjwg_maps_lng_c;";
  $db->query($query, false);
  $query = "ALTER TABLE cases_cstm DROP jjwg_maps_lat_c;";
  $db->query($query, false);
  $query = "ALTER TABLE cases_cstm DROP jjwg_maps_geocode_status_c;";
  $db->query($query, false);
  $query = "ALTER TABLE cases_cstm DROP jjwg_maps_address_c;";
  $db->query($query, false);

  $query = "ALTER TABLE contacts_cstm DROP jjwg_maps_lng_c;";
  $db->query($query, false);
  $query = "ALTER TABLE contacts_cstm DROP jjwg_maps_lat_c;";
  $db->query($query, false);
  $query = "ALTER TABLE contacts_cstm DROP jjwg_maps_geocode_status_c;";
  $db->query($query, false);
  $query = "ALTER TABLE contacts_cstm DROP jjwg_maps_address_c;";
  $db->query($query, false);

  $query = "ALTER TABLE leads_cstm DROP jjwg_maps_lng_c;";
  $db->query($query, false);
  $query = "ALTER TABLE leads_cstm DROP jjwg_maps_lat_c;";
  $db->query($query, false);
  $query = "ALTER TABLE leads_cstm DROP jjwg_maps_geocode_status_c;";
  $db->query($query, false);
  $query = "ALTER TABLE leads_cstm DROP jjwg_maps_address_c;";
  $db->query($query, false);

  $query = "ALTER TABLE opportunities_cstm DROP jjwg_maps_lng_c;";
  $db->query($query, false);
  $query = "ALTER TABLE opportunities_cstm DROP jjwg_maps_lat_c;";
  $db->query($query, false);
  $query = "ALTER TABLE opportunities_cstm DROP jjwg_maps_geocode_status_c;";
  $db->query($query, false);
  $query = "ALTER TABLE opportunities_cstm DROP jjwg_maps_address_c;";
  $db->query($query, false);

  $query = "ALTER TABLE project_cstm DROP jjwg_maps_lng_c;";
  $db->query($query, false);
  $query = "ALTER TABLE project_cstm DROP jjwg_maps_lat_c;";
  $db->query($query, false);
  $query = "ALTER TABLE project_cstm DROP jjwg_maps_geocode_status_c;";
  $db->query($query, false);
  $query = "ALTER TABLE project_cstm DROP jjwg_maps_address_c;";
  $db->query($query, false);

  $query = "ALTER TABLE meetings_cstm DROP jjwg_maps_lng_c;";
  $db->query($query, false);
  $query = "ALTER TABLE meetings_cstm DROP jjwg_maps_lat_c;";
  $db->query($query, false);
  $query = "ALTER TABLE meetings_cstm DROP jjwg_maps_geocode_status_c;";
  $db->query($query, false);
  $query = "ALTER TABLE meetings_cstm DROP jjwg_maps_address_c;";
  $db->query($query, false);

  $query = "ALTER TABLE prospects_cstm DROP jjwg_maps_lng_c;";
  $db->query($query, false);
  $query = "ALTER TABLE prospects_cstm DROP jjwg_maps_lat_c;";
  $db->query($query, false);
  $query = "ALTER TABLE prospects_cstm DROP jjwg_maps_geocode_status_c;";
  $db->query($query, false);
  $query = "ALTER TABLE prospects_cstm DROP jjwg_maps_address_c;";
  $db->query($query, false);
  */
}

