<?php

/**
 * @Project:          LiteSpeed Cache module for Nukeviet 4.x
 * Module Name:       LiteSpeed Cache
 * Module URI:        https://123host.vn/hosting.html
 * Description:       Nukeviet module to connect to Litespeed Web Server
 * Version:           1.0.01
 * Author:            Digital Storage Company Limited
 * Author URI:        https://123host.vn/
 * License:           GPLv3
 * License URI:       http://www.gnu.org/licenses/gpl.html
 * Text Domain:       litespeedcache
 * @Createdate:       Fri, 11 Aug 2017 09:48:43 GMT
 *
 * @Copyright (C) 2017 Digital Storage Company Limited. All rights reserved
 *
 * This program is distributed by 123HOST in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

$sql_drop_module = array();
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_config";


$sql_create_module = $sql_drop_module;
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_config (
  lang varchar(3)  COLLATE utf8_unicode_ci NOT NULL DEFAULT 'sys',
  module varchar(50)  COLLATE utf8_unicode_ci NOT NULL DEFAULT 'global',
  config_name varchar(30)  COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  config_value text  COLLATE utf8_unicode_ci,
  UNIQUE KEY lang (lang,module,config_name)
) ENGINE=MyISAM;";

$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_config VALUES ('sys','global','cache_status','0'),('sys','global','first_run','0'),('sys','global','public_cache_ttl','604800'),('sys','global','front_page_cache_ttl','604800'),('sys','global','cache_login_page','0'),('sys','global','cache_favicon','1'),('sys','global','fix_purge_cache','0'),('sys','global','fix_cookie','0')";

$sql_create_module[] = "UPDATE " . NV_MODULES_TABLE . " SET custom_title='LiteSpeed Cache' WHERE title='".$module_name."'";

function fileDelContentWithPattern($file, $beginPattern, $endPattern, &$message) {
    global $lang_module;
    if ( !is_writable($file) ) {
        $message = 'File <strong>' . $file . '</strong> ' . $lang_module['123host_file_not_exist_or_write'];
        return FALSE;
    }

    $contentByLine = file($file);
    $matches  = preg_grep ($beginPattern, $contentByLine);
    $numberOfBlock = count($matches);

    for ($i=0; $i < $numberOfBlock; $i++) {

        /* Find Begin and End lines LiteSpeed Cache rewrite of Admin LOGIN */
        $contentByLine = file($file);
        foreach ( $contentByLine as $lineNum => $lineContent ) {
            if (preg_match($beginPattern, $lineContent)) {
                $beginLineNum = $lineNum;
            }
                
            if (preg_match($endPattern, $lineContent))
                $endLineNum = $lineNum;

        }

        // Detroy lines
        if (is_numeric($beginLineNum) && is_numeric($endLineNum)) {
            foreach ( $contentByLine as $lineNum => $lineContent ) {
                if ( $lineNum >= $beginLineNum && $lineNum <= $endLineNum ) {
                    $contentByLine[$lineNum] = "";
                }
            } 
            if (! file_put_contents($file, implode("", $contentByLine), LOCK_EX) ) {
                $message = 'File <strong>' . $file . '</strong> ' . $lang_module['123host_file_not_exist_or_write'];
                return FALSE;
            }

        }
    }

    $message = $lang_module['123host_edit_file'] . $file . '</strong> ' .$lang_module['123host_success'];
    return TRUE;
}

/*
    Xóa các file đã thêm vào admin_login.php và admin_logout.php
    Run lúc uninstall module để gỡ bỏ module
*/
function removeCookieHandle(&$message) {
    global $lang_module;

    /* Remove Cookie Handle in admin LOGIN file */
    $adminLoginFile = NV_ROOTDIR . '/includes/core/admin_login.php';
    $beginAddCookiePattern = "/LiteSpeed Cache begin add cookie/";
    $endAddCookiePattern = "/LiteSpeed Cache end add cookie/";

    $adminLogoutFile = NV_ROOTDIR . '/includes/core/admin_logout.php';
    $beginAdminLogoutPattern = "/LiteSpeed Cache begin remove cookie/";
    $endAdminLogoutPattern = "/LiteSpeed Cache end remove cookie/";

    /* Remove Cookie Handle in shop module */
    $shopSetCartFile = NV_ROOTDIR . '/modules/shops/funcs/setcart.php';
    fileDelContentWithPattern($shopSetCartFile, $beginAddCookiePattern, $endAddCookiePattern, $message);

    /* Remove Cookie Handle in admin LOGIN and LOGOUT file */

    if ( fileDelContentWithPattern($adminLoginFile, $beginAddCookiePattern, $endAddCookiePattern, $message) && fileDelContentWithPattern($adminLogoutFile, $beginAdminLogoutPattern, $endAdminLogoutPattern, $message) ) {
        $message = $lang_module['123host_init_cache_success'];
        return TRUE;
    } else {
        return FALSE;
    }
}

function removePurgeCacheHandle(&$message) {
    global $lang_module;
    
    $cacheFile = NV_ROOTDIR . '/vendor/vinades/nukeviet/Cache/Files.php';        
    
    $beginModifyPattern = "/LiteSpeed Cache begin mofidy/";
    $endModifyPattern = "/LiteSpeed Cache end mofidy/";
    
    if ( fileDelContentWithPattern($cacheFile, $beginModifyPattern, $endModifyPattern, $message) ) {
        $message = $lang_module['123host_init_cache_success'];
        return TRUE;
    } else {
        return FALSE;
    }

}

/*
    Tắt rewrite cache tại .htaccess
        Xóa tất cả các rewrite rule cache
*/
function disableCacheRewrite(&$message) {
    global $lang_module;
    $htaccessFile = NV_ROOTDIR . '/.htaccess';

    /** Try to delete LiteSpeed Cache content from .htaccess file **/
    $beginPattern = "/########## Begin LiteSpeed Cache/";
    $endPattern = "/########## End - LiteSpeed Cache/";

    if ( fileDelContentWithPattern($htaccessFile, $beginPattern, $endPattern, $message) ) {
        $message = $lang_module['123host_disable_cache_success'];
        return TRUE;
    } else {
        $message = $lang_module['123host_disable_cache_failure'] . " <a href='" . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=litespeedcache&amp;' . NV_OP_VARIABLE . '=main' . '&amp;' . 'action=checkRequirement' . "'>"  . $lang_module['123host_check_check_req']  . "</a>";
        return FALSE;
    }
}

/* Thực hiện xóa các dòng đã thêm vào các file của Nukeviet + Reset table config của module nếu người dùng thực hiện xóa module hoặc Cài lại module */
global  $op;
if ($op == 'del' || $op == 'recreate_mod') {
    removeCookieHandle($message);
    removePurgeCacheHandle($message);
    disableCacheRewrite($message);
    $query = "TRUNCATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_config";
    $row = $db->prepare($query); 
    $row->execute();

    $query = "INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_config VALUES ('sys','global','cache_status','0'),('sys','global','first_run','0'),('sys','global','public_cache_ttl','604800'),('sys','global','front_page_cache_ttl','604800'),('sys','global','cache_login_page','0'),('sys','global','cache_favicon','1'),('sys','global','fix_purge_cache','0'),('sys','global','fix_cookie','0')";
    $row = $db->prepare($query); 
    $row->execute();
    
}