<?php

if (! defined('NV_IS_TKB_ADMIN')) {
    die('Stop!!!');
}

$page_title = $lang_module['config'];
$result_action = '';

// Khi nhấp xóa dữ liệu
if ($nv_Request->isset_request('do', 'post')) {
	$new_day_apply = $nv_Request->get_title('day_apply','post');
	$new_title_tkb_lop = $nv_Request->get_title('title_tkb_lop','post');
	$new_title_tkb_gv = $nv_Request->get_title('title_tkb_gv','post');

	$db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_config SET cfg_value = '".$new_day_apply."' WHERE cfg_name = 'day_apply'");
	$db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_config SET cfg_value = '".$new_title_tkb_lop."' WHERE cfg_name = 'title_tkb_lop'");
	$db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_config SET cfg_value = '".$new_title_tkb_gv."' WHERE cfg_name = 'title_tkb_gv'");
	$result_action = "Cập nhật xong !";
}

// Get config
$day_apply = $db->query("SELECT cfg_value FROM " . NV_PREFIXLANG . "_" . $module_data . "_config WHERE cfg_name = 'day_apply'")->fetch()['cfg_value'];
$title_tkb_lop = $db->query("SELECT cfg_value FROM " . NV_PREFIXLANG . "_" . $module_data . "_config WHERE cfg_name = 'title_tkb_lop'")->fetch()['cfg_value'];
$title_tkb_gv = $db->query("SELECT cfg_value FROM " . NV_PREFIXLANG . "_" . $module_data . "_config WHERE cfg_name = 'title_tkb_gv'")->fetch()['cfg_value'];

$action = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=config';

$xtpl = new XTemplate('config.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('FORM_ACTION', $action);
$xtpl->assign('DAY_APPLY', $day_apply);
$xtpl->assign('TITLE_TKB_LOP', $title_tkb_lop);
$xtpl->assign('TITLE_TKB_GV', $title_tkb_gv);

if ($result_action) {
	$xtpl->assign('RESULT_ACTION', $result_action);
	$xtpl->parse('main.result_action');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');
 
include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");