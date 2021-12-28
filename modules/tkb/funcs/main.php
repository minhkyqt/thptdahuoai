<?php

if (! defined('NV_IS_MOD_TKB')) {
    die('Stop!!!');
}

$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];

$day_apply = $db->query("SELECT cfg_value FROM " . NV_PREFIXLANG . "_" . $module_data . "_config WHERE cfg_name = 'day_apply'")->fetch()['cfg_value'];
$title_tkb = $db->query("SELECT cfg_value FROM " . NV_PREFIXLANG . "_" . $module_data . "_config WHERE cfg_name = 'title_tkb_lop'")->fetch()['cfg_value'];

$result = $db->query("SELECT DISTINCT lop FROM " . NV_PREFIXLANG . "_" . $module_data . "_lop ORDER BY lop ASC");
$ds_lop = [];
while ($row = $result->fetch()) {
    $ds_lop[] = $row['lop'];
}

if ($nv_Request->get_title('keywords', 'post')) {
	$lop_ht = $nv_Request->get_title('keywords', 'post');
	$lop_ht = stripslashes(trim($lop_ht));

	$result = $db->query("SELECT tiet, buoi, thu2, thu3, thu4, thu5, thu6, thu7 FROM " . NV_PREFIXLANG . "_" . $module_data . "_lop WHERE (lop LIKE '".$lop_ht."') ORDER BY tiet ASC");
	$tkb = [];
	$i = 0;
	$num_time0 = 0;
	$num_time1 = 0;
	while ($rows = $result->fetch()){
		$tkb[$i] = [ $rows['tiet'], $rows['thu2'], $rows['thu3'], $rows['thu4'], $rows['thu5'], $rows['thu6'], $rows['thu7'], 'buoi' => $rows['buoi'] ];
		if ($rows['buoi'] == 0) {
		   	$num_time0++;
	   	}
	   	if ($rows['buoi'] == 1) {
		   	$num_time1++;
	   	} 
		$i++;
	} 

	$contents = view_site_main($title_tkb, $day_apply, $ds_lop, $lop_ht, $tkb, $num_time0, $num_time1);
} else {
	$contents = view_site_main($title_tkb, $day_apply, $ds_lop);
}

include (NV_ROOTDIR . "/includes/header.php");
echo nv_site_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");