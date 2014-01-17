<?php 

// custom/modules/Opportunities/views/view.list.php

require_once('include/MVC/View/views/view.list.php');

class CustomOpportunitiesViewList extends ViewList {

    public function preDisplay() {

        parent::preDisplay();
        $this->lv->actionsMenuExtraItems[] = $this->buildMyMenuItem();
    }

    protected function buildMyMenuItem() {

        global $app_strings;
        global $sugar_config;

        if (preg_match('/^6\.[2-4]/', $sugar_config['sugar_version'])) { // Older v6.2-6.4

            $script = "<a href='#' style='width: 150px' class='menuItem' onmouseover='hiliteItem(this,\"yes\");' " .
                    "onmouseout='unhiliteItem(this);' onclick=\"return sListView.send_form(true, 'jjwg_Maps', " .
                    "'index.php?entryPoint=jjwg_Maps&display_module={$_REQUEST['module']}', " .
                    "'{$app_strings['LBL_LISTVIEW_NO_SELECTED']}')\">{$app_strings['LBL_MAP']}</a>";

        } else { // Newer v6.5+

            $script = "<a href='javascript:void(0)' id='map_listview_top' " .
                    " onclick=\"return sListView.send_form(true, 'jjwg_Maps', " .
                    "'index.php?entryPoint=jjwg_Maps&display_module={$_REQUEST['module']}', " .
                    "'{$app_strings['LBL_LISTVIEW_NO_SELECTED']}')\">{$app_strings['LBL_MAP']}</a>";
	}

        return $script;
    }
}

