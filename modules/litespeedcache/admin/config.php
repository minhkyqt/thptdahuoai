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

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_LANG_VARIABLE', NV_LANG_VARIABLE );
$xtpl->assign( 'NV_LANG_DATA', NV_LANG_DATA );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );

/* 
    Lấy các giá trị cấu hình cache tại table _config của module 
        $publicCacheTTL : Thời gian cache chung (giây)
        $frontPageCacheTTL : Giờ gian cache trang chủ (giây)
        $cacheLoginPage : Có cache login page hay không
        $cacheFavicon : Có cache Favicon hay không
*/

try {
    $query = "SELECT config_value FROM " . $db_config['prefix'] . "_" . $module_data . "_config WHERE config_name='cache_status'";
    $row = $db->query($query)->fetch();
    $cacheStatus = $row['config_value'];
} catch( PDOException $e ) {
    trigger_error( $e->getMessage() );
}

try {
    $query = "SELECT config_value FROM " . $db_config['prefix'] . "_" . $module_data . "_config WHERE config_name='public_cache_ttl'";
    $row = $db->query($query)->fetch();
    $publicCacheTTL = $row['config_value'];
} catch( PDOException $e ) {
    trigger_error( $e->getMessage() );
}

try {
    $query = "SELECT config_value FROM " . $db_config['prefix'] . "_" . $module_data . "_config WHERE config_name='front_page_cache_ttl'";
    $row = $db->query($query)->fetch();
    $frontPageCacheTTL = $row['config_value'];
} catch( PDOException $e ) {
    trigger_error( $e->getMessage() );
}

try {
    $query = "SELECT config_value FROM " . $db_config['prefix'] . "_" . $module_data . "_config WHERE config_name='cache_login_page'";
    $row = $db->query($query)->fetch();
    $cacheLoginPage = $row['config_value'];
} catch( PDOException $e ) {
    trigger_error( $e->getMessage() );
}

try {
    $query = "SELECT config_value FROM " . $db_config['prefix'] . "_" . $module_data . "_config WHERE config_name='cache_favicon'";
    $row = $db->query($query)->fetch();
    $cacheFavicon = $row['config_value'];
} catch( PDOException $e ) {
    trigger_error( $e->getMessage() );
}

/*
    Lấy các giá trị submit từ form. Nếu không có giá trị sẽ = 0
*/

$newPublicCacheTTL = $nv_Request->get_int('public_cache_ttl', 'post');
$newFrontPageCacheTTL = $nv_Request->get_int('front_page_cache_ttl', 'post');

$newCacheLoginPage = $nv_Request->get_int('cache_login_page', 'post');
$newCacheFavicon = $nv_Request->get_int('cache_favicon', 'post');

/* Nếu có submit form */
if ($newPublicCacheTTL != 0) {

    /* Insert dữ liệu mới từ form vào CSDL */
    try {
        $query = "UPDATE " . $db_config['prefix'] . "_" . $module_data . "_config SET config_value='" . $newPublicCacheTTL ."' WHERE config_name='public_cache_ttl'";
        $row = $db->prepare($query); 
        $row->execute();

        $query = "UPDATE " . $db_config['prefix'] . "_" . $module_data . "_config SET config_value='" . $newFrontPageCacheTTL ."' WHERE config_name='front_page_cache_ttl'";
        $row = $db->prepare($query); 
        $row->execute();
        
        $query = "UPDATE " . $db_config['prefix'] . "_" . $module_data . "_config SET config_value='" . $newCacheLoginPage ."' WHERE config_name='cache_login_page'";
        $row = $db->prepare($query); 
        $row->execute();

        $query = "UPDATE " . $db_config['prefix'] . "_" . $module_data . "_config SET config_value='" . $newCacheFavicon ."' WHERE config_name='cache_favicon'";
        $row = $db->prepare($query); 
        $row->execute();
    } catch( PDOException $e ) {
        trigger_error( $e->getMessage() );
    }

    /* Build lại file .htaccess với cấu hình mới nếu Cache đang bật */
    if ($cacheStatus == 1) {
        disableCacheRewrite($message);
        enableCacheRewrite($newPublicCacheTTL, $newFrontPageCacheTTL, $newCacheLoginPage, $newCacheFavicon ,$message);
    }
    
    /* Gán các giá trị mới cho vào view */
    $xtpl->assign( 'MESSAGE', "<div class=\"notice notice-success is-dismissible\"> <p> " . $lang_module['123host_settings_saved'] . "</p> </div>" );
    $xtpl->assign( 'PUBLIC_CACHE_TTL', $newPublicCacheTTL );
    $xtpl->assign( 'FRONT_PAGE_CACHE_TTL', $newFrontPageCacheTTL );

    if ($newCacheLoginPage == '0') {
        $xtpl->assign( 'DISABLE_CACHE_LOGIN_PAGE_CHECKED',"checked");
    } else {
       $xtpl->assign( 'ENABLE_CACHE_LOGIN_PAGE_CHECKED',"checked");
    }
    
    if ($newCacheFavicon == '0') {
        $xtpl->assign( 'DISABLE_CACHE_FAVICON_CHECKED',"checked");
    } else {
       $xtpl->assign( 'ENABLE_CACHE_FAVICON_CHECKED',"checked");
    }
    
/*
    Nếu không có submit form. Giá trị cần đưa ra view là giá trị cũ từ CSDL
*/
} else {
    $xtpl->assign( 'PUBLIC_CACHE_TTL', $publicCacheTTL );
    $xtpl->assign( 'FRONT_PAGE_CACHE_TTL', $frontPageCacheTTL );

    if ($cacheLoginPage == '0') {
        $xtpl->assign( 'DISABLE_CACHE_LOGIN_PAGE_CHECKED',"checked");
    } else {
       $xtpl->assign( 'ENABLE_CACHE_LOGIN_PAGE_CHECKED',"checked");
    }

    if ($cacheFavicon == '0') {
        $xtpl->assign( 'DISABLE_CACHE_FAVICON_CHECKED',"checked");
    } else {
       $xtpl->assign( 'ENABLE_CACHE_FAVICON_CHECKED',"checked");
    }
}

$xtpl->parse( 'config' );
$contents = $xtpl->text( 'config' );

$page_title = $lang_module['config'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';
