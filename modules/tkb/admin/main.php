<?php

if (! defined('NV_IS_TKB_ADMIN')) {
    die('Stop!!!');
}

$page_title = $lang_module['module_name'];
$result_del = '';
// Khi nhấp xóa dữ liệu
if ($nv_Request->isset_request('del', 'post')) {
	$db->query("TRUNCATE " . NV_PREFIXLANG . "_" . $module_data . "_lop");
	$db->query("TRUNCATE " . NV_PREFIXLANG . "_" . $module_data . "_giaovien");
	$result_del = 'Đã xóa toàn bộ dữ liệu';
}

$url_import_lop = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=import_lop';
$url_import_giaovien = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=import_giaovien';
$action_del = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=main';

$xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('URL_IMPORT_LOP', $url_import_lop);
$xtpl->assign('URL_IMPORT_GV', $url_import_giaovien);
$xtpl->assign('FORM_ACTION', $action_del);

if ($result_del) {
	$xtpl->assign('RESULT_DEL', $result_del);
	$xtpl->parse('main.result_del');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');
 
include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");