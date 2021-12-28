<?php

if (! defined('NV_IS_MOD_TKB')) {
    die('Stop!!!');
}

function view_site_main($title_tkb, $day_apply, $ds_lop, $lop_ht = '', $tkb = NULL, $num_time0 = 0, $num_time1 = 0) {
    
    global $module_file, $lang_module, $lang_global, $module_info;
 
    $template = (file_exists(NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file . '/main.tpl')) ? $module_info['template'] : 'default';
 
    $xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $template . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
	
	if (!empty($ds_lop)) {
       	foreach ($ds_lop as $lop){
       		$xtpl->assign('LOP', $lop);
       		if ($lop_ht == $lop) {
       			$xtpl->parse('main.block_table.loop_ds_selected');
       		} else {
       			$xtpl->parse('main.block_table.loop_ds');
       		}
       	}
       	if ($lop_ht) {
       		$xtpl->parse('main.block_table.loop_ds.selected_lop');
       		$xtpl->assign('LOP_HT', $lop_ht);
       		
          if ($num_time0 > 0) {
            foreach ($tkb as $value) {
              if($value['buoi'] == 0) {
                $xtpl->assign('TKB', $value);
                $xtpl->parse('main.block_tablekq.block_show_sang.loop_kq');
              }
            }
            $xtpl->parse('main.block_tablekq.block_show_sang');
          }
          if ($num_time1 > 0) {
            foreach ($tkb as $value) {
              if($value['buoi'] == 1) {
                $xtpl->assign('TKB', $value);
                $xtpl->parse('main.block_tablekq.block_show_chieu.loop_kq');
              }
            }
            $xtpl->parse('main.block_tablekq.block_show_chieu');
          }
       		$xtpl->parse('main.block_tablekq.block_show');
       		$xtpl->parse('main.block_tablekq');
       	}
    }
    $xtpl->parse('main.block_table');
    $xtpl->assign('DAY_APPLY', $day_apply);
    $xtpl->assign('TITLE_TKB', $title_tkb);
    $xtpl->assign('LINK_CSS_SELECT2', NV_BASE_SITEURL . 'themes/' . $template . '/modules/' . $module_file . '/plugins/select2/css/select2.min.css');
    $xtpl->assign('LINK_JS_SELECT2', NV_BASE_SITEURL . 'themes/' . $template . '/modules/' . $module_file . '/plugins/select2/js/select2.min.js');

    $xtpl->parse('main');
    return $xtpl->text('main');
}

function view_giaovien($title_tkb, $day_apply, $ds_gv, $gv_ht = '', $tkb = NULL) {
    
    global $module_file, $lang_module, $lang_global, $module_info;
 
    $template = (file_exists(NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file . '/giaovien.tpl')) ? $module_info['template'] : 'default';
 
    $xtpl = new XTemplate('giaovien.tpl', NV_ROOTDIR . '/themes/' . $template . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
  
  if (!empty($ds_gv)) {
        foreach ($ds_gv as $gv){
          $xtpl->assign('GV', $gv);
          if ($gv_ht == $gv) {
            $xtpl->parse('main.block_table.loop_ds_selected');
          } else {
            $xtpl->parse('main.block_table.loop_ds');
          }
        }
        if ($gv_ht) {
          $xtpl->parse('main.block_table.loop_ds.selected_lop');
          $xtpl->assign('GV_HT', $gv_ht);
          foreach ($tkb as $value) {
            if($value['buoi'] == 0) {
              $xtpl->assign('TKB', $value);
              $xtpl->parse('main.block_tablekq.block_show_sang.loop_kq');
            }
          }
          $xtpl->parse('main.block_tablekq.block_show_sang');
          foreach ($tkb as $value) {
            if($value['buoi'] == 1) {
              $xtpl->assign('TKB', $value);
              $xtpl->parse('main.block_tablekq.block_show_chieu.loop_kq');
            }
          }
          $xtpl->parse('main.block_tablekq.block_show_chieu');

          $xtpl->parse('main.block_tablekq');
        }
    }
    $xtpl->parse('main.block_table');
    $xtpl->assign('DAY_APPLY', $day_apply);
    $xtpl->assign('TITLE_TKB', $title_tkb);
    $xtpl->assign('LINK_CSS_SELECT2', NV_BASE_SITEURL . 'themes/' . $template . '/modules/' . $module_file . '/plugins/select2/css/select2.min.css');
    $xtpl->assign('LINK_JS_SELECT2', NV_BASE_SITEURL . 'themes/' . $template . '/modules/' . $module_file . '/plugins/select2/js/select2.min.js');

    $xtpl->parse('main');
    return $xtpl->text('main');
}