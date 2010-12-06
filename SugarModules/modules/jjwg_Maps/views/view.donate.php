<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class Jjwg_MapsViewDonate extends SugarView {

 	function Jjwg_MapsViewDonate() {
 		parent::SugarView();
 	}
	
	function display() {
		
		global $sugar_config;
		global $currentModule;
		
?>

<p style="margin: 15px 0px 15px 0px; font-size: 2em;"><strong>Please, donate to this project!</strong></p>

<p style="margin: 15px 0px 15px 0px; font-size: 1.2em; width: 700px;">
If you've found this project helpful, please donate! Donations from users like you will help keep this project alive.
</p>

<div style="margin: 15px 0px 15px 0px;">
<span style="font-size: 3em;"><strong>$1, $5, $20 or even $50 &nbsp;</strong></span>
<form style="display:inline;" action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="FZENX6PLHKX2L">
<input style="border:0;" type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
</div>
<br />

<p style="margin: 15px 0px 15px 0px; font-size: 2em;"><strong>Free Version</strong></p>

<p style="margin: 15px 0px 15px 0px; font-size: 1.2em; line-height: 1.5em; width: 700px;">
This is the Free Small Businesses Version of this project and supports up to 10 users to be displayed at one time.
In order to display up to 216 different users at one time, please donate $20 or more and 
I will send you the complete user icon sets. Make sure to enter a valid email address with your donatation.
</p>


<p style="margin: 15px 0px 15px 0px; font-size: 2em;"><strong>Support or Customization Services</strong></p>

<p style="margin: 15px 0px 15px 0px; font-size: 1.2em; line-height: 1.5em; width: 700px;">
Donations of $20 or more receive an hour of support or customization services to ensure you get your maps up and running properly.
</p>
<br />


<p style="margin: 15px 0px 15px 0px; font-size: 2em;"><strong>Professional Version</strong></p>

<p style="margin: 15px 0px 15px 0px; font-size: 1.2em; line-height: 1.5em; width: 700px;">
A professional version is now available for $250.00 US. The professional version includes three additional modules that 
work with the base Maps module to provide even more functionality. These three modules are as follows.
</p>
<p style="margin: 15px 0px 15px 0px; font-size: 1.2em; line-height: 1.5em; width: 700px;">
<strong>Address Cache Module:</strong> This module provides help with the importing and exporting of geocode data.
Addresses in-need of geocoding can easily be exported. Geocoding can then be done with your favorite online/offline application.
Later after geocoding, the address cache information can be imported or updated.
Address Cache information is used during the &quot;Geocoding Addresses&quot; process and proceeds the Google Geocoding request.
</p>
<p style="margin: 15px 0px 15px 0px; font-size: 1.2em; line-height: 1.5em; width: 700px;">
<strong>Custom Markers Module:</strong> This module provides an easy way to define custom markers with many different icons to choose from.
It's a great way to define your favorite meeting places, restaurants, airports, trip highlights or other locations.
Custom markers can be added to any of your maps created by the maps module.
Tools are provided to either hand position the markers or address geocoding can be done to determine position. 
</p>
<p style="margin: 15px 0px 15px 0px; font-size: 1.2em; line-height: 1.5em; width: 700px;">
<strong>Custom Areas (Polygons) Module:</strong> This module provides an easy way to define custom areas
using polygon shapes. These areas can represent the various Sales Areas for your company.
Custom polygon areas can be added to multiple maps.
An advanced mapping tool is provided to define the polygon geocoded points.
</p>

<p style="margin: 15px 0px 15px 0px; font-size: 1.2em;">
Thank you for your support and understanding,<br />
Jeff Walters<br />
<a href="http://www.jjwdesign.com/">JJW Design</a><br />
<a href="mailto:jjwdesign@gmail.com">jjwdesign@gmail.com</a><br />
</p>



<?php

 	}
}

?>