<?php
require_once('include/ListView/ListViewSmarty.php');

// custom/modules/Leads/LeadsListViewSmarty.php

class LeadsListViewSmarty extends ListViewSmarty {
	
	function LeadsListViewSmarty(){
	
		parent::ListViewSmarty();
	
	}
	
	function buildExportLink($id = 'export_link')  {
	
		global $app_strings;
		global $sugar_config;
		
		if (preg_match('/^5\.(2|5)/', $sugar_config['sugar_version'])) {
		
			$script = '<input class="button" type="button" value="'.$app_strings['LBL_EXPORT'].'" ' .
					'onclick="return sListView.send_form(true, \''.$_REQUEST['module'].'\', \'index.php?entryPoint=export\',\''.
					$app_strings['LBL_LISTVIEW_NO_SELECTED'].'\')">'.
					'<input class="button" type="button" value="'.$app_strings['LBL_MAP'].'" ' .
					'onclick="return sListView.send_form(true, \''.$_REQUEST['module'].'\', \'index.php?entryPoint=jjwg_Maps&display_module='.
					$_REQUEST['module'].'\',\''.$app_strings['LBL_LISTVIEW_NO_SELECTED'].'\')">';
		
		} elseif (preg_match('/^6\./', $sugar_config['sugar_version'])) {
		
			$script = "<a href='#' style='width: 150px' class='menuItem' onmouseover='hiliteItem(this,\"yes\");' ".
					"onmouseout='unhiliteItem(this);' onclick=\"return sListView.send_form(true, '{$_REQUEST['module']}', ".
					"'index.php?entryPoint=export','{$app_strings['LBL_LISTVIEW_NO_SELECTED']}')\">{$app_strings['LBL_EXPORT']}</a>".
			
					"<a href='#' style='width: 150px' class='menuItem' onmouseover='hiliteItem(this,\"yes\");' ".
					"onmouseout='unhiliteItem(this);' onclick=\"return sListView.send_form(true, 'jjwg_Maps', ".
					"'index.php?entryPoint=jjwg_Maps&display_module={$_REQUEST['module']}', ".
					"'{$app_strings['LBL_LISTVIEW_NO_SELECTED']}')\">{$app_strings['LBL_MAP']}</a>";
		
		}
		
		return $script;
	}

}

?>