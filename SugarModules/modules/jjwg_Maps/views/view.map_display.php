<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class Jjwg_MapsViewMap_Display extends SugarView {

  function Jjwg_MapsViewMap_Display() {
    parent::SugarView();
  }
  
  function display() {
    
    $url = 'index.php?module='.$GLOBALS['currentModule'].'&action=map_markers';
    foreach (array_keys($_REQUEST) as $key) {
      if (!in_array($key, array('action', 'module', 'entryPoint'))) {
        $url .= '&'.$key.'='.urlencode($_REQUEST[$key]);
      }
    }
    
?>
<script type="text/javascript" src="modules/jjwg_Maps/javascript/jquery.iframe-auto-height.plugin.1.9.3.min.js"></script>
<script>

  function resizeDataTables() {
      console.log('Hello from resizeDataTables');
      $('#mapDisplayIframe').css('height: 200px;');
      setTimeout(function() {
          $('#resizeMapDisplayIframe').trigger("click");
      }, 250);
  }
  
  $(document).ready(function () {
    
    // fire iframe resize when window is resized
    var windowResizeFunction = function(resizeFunction, iframe) {
        $(window).resize(function () {
            console.debug("window resized - firing resizeHeight on iframe");
            resizeFunction(iframe);
        });
    };
    
    // fire iframe resize when a link is clicked
    var clickFunction = function (resizeFunction, iframe) {
        $('#resizeMapDisplayIframe').click(function () {
            console.debug("link clicked - firing resizeHeight on iframe");
            resizeFunction(iframe);
            return false
        });
    };
    
    $('#mapDisplayIframe').iframeAutoHeight({
        debug: true,
        triggerFunctions: [
            windowResizeFunction,
            clickFunction
        ]
    });
    
  });
  
</script>

<iframe id="mapDisplayIframe" src="<?php echo $url; ?>" 
	width="100%" height="900" frameborder="0" marginheight="0" marginwidth="0" 
        scrolling="auto"><p>Sorry, your browser does not support iframes.</p></iframe>

<?php
    if (empty($_REQUEST['uid']) && empty($_REQUEST['current_post'])) {
?>
<p>IFrame: 
    <a href="<?php echo htmlspecialchars($url); ?>"><?php echo $GLOBALS['mod_strings']['LBL_MAP']; ?> URL</a> 
    <a href="#" id="resizeMapDisplayIframe" style="display: none;">.</a>
</p>
<?php 
    }
?>


<?php

  }
}
