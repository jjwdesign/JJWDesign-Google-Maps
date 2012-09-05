<?php

function post_install() {

  if ($_REQUEST['mode'] == 'Install') {

?>
<br /><br />

<div style="margin: 15px;">




<span style="font-size: 1.7em;"><strong>Congratulations! JJW Design's Google Maps Package has been installed!</strong></span>

<p style="margin: 15px 0px 15px 0px; font-size: 1.25em; width: 700px;">
The installation process has completed. There's no API key to setup with Google Maps V3. 
The next step is to go to your new 
&quot;<a href="./index.php?module=jjwg_Maps&action=geocoded_counts&return_module=jjwg_Maps&return_action=index">Maps Module</a>&quot; 
and Geocode Addresses.
Keep in mind that this process is throttled and limited to 2,500 addresses per day by Google Maps.
</p>




     
<p style="margin: 15px 0px 15px 0px; font-size: 1.7em;"><strong>Please, donate to this project!</strong></p>

<p style="margin: 15px 0px 15px 0px; font-size: 1.25em; width: 700px;">
If you've found this project helpful, please donate!<br />
Donations from users like you will help keep this project alive.
</p>

<div style="margin: 15px 0px 15px 0px;">
<span style="font-size: 1.7em;"><strong>$5, $20, $100 or even $500 &nbsp;</strong></span>
<form style="display:inline;" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="FZENX6PLHKX2L">
<input style="border:0;" type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
</div>
<br />

<p style="margin: 15px 0px 15px 0px; font-size: 1.25em; line-height: 1.5em; width: 700px;">
<b>This project is COMPLETELY FREE!</b>, but relies heavily on donations to keep it alive. 
</p>

<p style="margin: 15px 0px 15px 0px; font-size: 1.7em;"><strong>All Professional Modules are Now Included (02/09/2012)</strong></p>


<p style="margin: 15px 0px 15px 0px; font-size: 1.25em; line-height: 1.5em; width: 700px;">
Several additional advanced modules (previously referred to as the professional version) have now been added to this package. 
All future versions will include the professional version modules (several enhancements). 
All professional version features and modules are included in this free version that you are using now.
</p>
<p style="margin: 15px 0px 15px 0px; font-size: 1.25em; line-height: 1.5em; width: 700px;">
<strong>&quot;Address Cache&quot; Module:</strong> This module provides help with the importing and exporting of geocode data.
Addresses in-need of geocoding can easily be exported. Geocoding can then be done with your favorite online/offline application.
Later after geocoding, the address cache information can be imported or updated.
Address Cache information is used during the &quot;Geocoding Addresses&quot; process and proceeds the Google Geocoding request.
</p>
<p style="margin: 15px 0px 15px 0px; font-size: 1.25em; line-height: 1.5em; width: 700px;">
<strong>Custom &quot;Markers&quot; Module:</strong> This module provides an easy way to define custom markers with many different icons to choose from.
It's a great way to define your favorite meeting places, restaurants, airports, trip highlights or other locations.
Custom markers can be added to any of your maps created by the maps module.
Tools are provided to either hand position the markers or address geocoding can be done to determine position. 
</p>
<p style="margin: 15px 0px 15px 0px; font-size: 1.25em; line-height: 1.5em; width: 700px;">
<strong>Custom &quot;Areas&quot; (Polygons) Module:</strong> This module provides an easy way to define custom areas
using polygon shapes. These areas can represent the various Sales Areas for your company.
Custom polygon areas can be added to multiple maps.
An advanced mapping tool is provided to define the polygon geocoded points.
</p>

<p style="margin: 15px 0px 15px 0px; font-size: 1.25em;">
Thank you for your support,<br />
Jeff Walters<br />
<a href="http://www.jjwdesign.com/">JJW Design</a><br />
<a href="mailto:jjwdesign@gmail.com">jjwdesign@gmail.com</a><br />
</p>

</div>



<?php
  }
}
?>