
<div class="marker"><b>{$moduleListSingular.Contacts}: 
<a target="_blank" 
href="index.php?module={$module_type}&action=DetailView&record={$fields.id}">{$fields.name}</a></b> 
<br />{$moduleListSingular.Accounts}: <a target="_blank" 
href="index.php?module=Accounts&action=DetailView&record={$fields.account_id}">{$fields.account_name}</a>
<br />{$address}<br />
<i>{$mod_strings.LBL_MAP_ASSIGNED_TO} {$fields.assigned_user_name}</i></div>
