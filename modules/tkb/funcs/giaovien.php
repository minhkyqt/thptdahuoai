<?php

if (! defined('NV_IS_MOD_TKB')) {
    die('Stop!!!');
}

$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];

$day_apply = $db->query("SELECT cfg_value FROM " . NV_PREFIXLANG . "_" . $module_data . "_config WHERE cfg_name = 'day_apply'")->fetch()['cfg_value'];
$title_tkb = $db->query("SELECT cfg_value FROM " . NV_PREFIXLANG . "_" . $module_data . "_config WHERE cfg_name = 'title_tkb_gv'")->fetch()['cfg_value'];
$result = $db->query("SELECT DISTINCT giaovien FROM " . NV_PREFIXLANG . "_" . $module_data . "_giaovien ORDER BY giaovien ASC");
$ds_gv = [];
while ($row = $result->fetch()) {
    $ds_gv[] = $row['giaovien'];
}

if ($nv_Request->get_title('keywords', 'post')) {
	$gv_ht = $nv_Request->get_title('keywords', 'post');
	$gv_ht = stripslashes(trim($gv_ht));

	$result = $db->query("SELECT tiet, buoi, thu2, thu3, thu4, thu5, thu6, thu7 FROM " . NV_PREFIXLANG . "_" . $module_data . "_giaovien WHERE (giaovien LIKE '".$gv_ht."') ORDER BY buoi ASC, tiet ASC");
	$tkb = [];
	$i = 0;
	
	while ($rows = $result->fetch()){
		$tkb[$i] = [ $rows['tiet'], $rows['thu2'], $rows['thu3'], $rows['thu4'], $rows['thu5'], $rows['thu6'], $rows['thu7'], 'buoi' => $rows['buoi']];    
		$i++;
	} 

	$contents = view_giaovien($title_tkb, $day_apply, $ds_gv, $gv_ht, $tkb);
} else {
	$contents = view_giaovien($title_tkb, $day_apply, $ds_gv);
}

include (NV_ROOTDIR . "/includes/header.php");
echo nv_site_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");