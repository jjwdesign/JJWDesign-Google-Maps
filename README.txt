JJWDesign Google Maps
Project hosted on SugarForge
Created by Jeffrey J. Walters
http://www.jjwdesign.com/
Copyright (C) 2010-2012 Jeffrey J. Walters


Version 2.0 Changes: 08/21/2012

Version 2.0 is a significant achievement for this project. We've come a long way from the simple idea of mapping leads. Thank you to all those who have contributed and/or donated.

Requirements:
1.) Version 2.0 now requires cURL to be installed on the server. file_get_contents() is no longer used, per SugarCRM On-Demand restrictions.

Improvements:

1.) Add Configuration Page: You can now adjust/save the majority of the settings thru this easy to use configuration form.
2.) Complete rewrite of view.map_markers.php to reduce the overall amount of JavaScript code. This was a much needed improvement. The intent is to allow the page to load faster and to be able to display a larger set of markers without crashing Internet Browsers. It should also make extending Javascript/Jquery/Google Maps API functionality much easier for future plugin development.
3.) Added functionality for mapping Meetings from the Meetings Module. Geocoding of the Meeting objects is based on the Related module type and record (flex relate). Custom list view changes.
4.) Added functionality for mapping Prospects/Targets from the Prospects Module. Custom list view changes. More on this soon.
5.) Complete rewrite of all Logic Hooks to better manage the address relationships on change (save). Several new logic hooks added. See custom/module directory for more details. This was a major overhaul of the logic hooks.
6.) Edit/Display View: Redefined the Parent Type list (flex relate field) for all Maps added in the jjwg_Maps Module. It now only allows you to select from Modules that have address information.
7.) Cache Improved: Additional logic now added to take full advantage of the Address Cache module. All successfully geocoded addresses are now stored in the Address Cache module for later retrieval.
8.) Serveral dozen or two small improvements that I don't recall at this time.
9.) Updated jQuery to version 1.8.0


Changes Specifically for SugarCRM On-Demand Users

1.) Removed instances of is_dir()
2.) Removed instanced of is_file()
3.) Removed any not acceptable file types
4.) Changed Google API Request from file_get_contents() to use PHP cURL.


Bugs:

1.) Bug: Many PHP notice messages corrected, for those running with them on.
2.) Bug: Corrected IE6 javascript error issues in view.map_markers.php
3.) Bug: CSS link path issue corrected.
4.) Bug: Corrected several bugs related to Map Areas/Markers display issues.



Install/Uninstall Notes:

If you wish in remove all custom fields see packaged scripts 
(scripts folder), pre_install.php and/or post_uninstall.php. 
Uncomment code if you wish to remove all custom fields and data.

GNU Affero General Public License:

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.


