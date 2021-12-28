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



try {
    $query = "SELECT config_value FROM " . $db_config['prefix'] . "_" . $module_data . "_config WHERE config_name='first_run'";
    $row = $db->query($query)->fetch();
    $firstRun = $row['config_value'];
} catch( PDOException $e ) {
    trigger_error( $e->getMessage() );
}

if(!checkRequirement($global_config['version'], $message)) {
        $xtpl->assign( 'MESSAGE',"<div class=\"notice notice-error is-dismissible\"> <p>" . $message . "</p> </div>", $result );
        goto action;
}

//  Nếu là lần đầu thì sẽ thực hiện chèn các đoạn code cần thiết và các file chỉ để Nukeviet 4 hỗ trợ Cache.
if ($firstRun == 0) {
    // Thực hiện thêm các đoạn code xử lý cookie vào Nukeviet
    removeCookieHandle($message);
    if(addCookieHandle($message)) {
        try {
            $query = "UPDATE " . $db_config['prefix'] . "_" . $module_data . "_config SET config_value='1' WHERE config_name='fix_cookie'";
            $row = $db->prepare($query);
            $row->execute();
        } catch( PDOException $e ) {
            trigger_error( $e->getMessage() );
        }
    }
    else {
        $xtpl->assign( 'MESSAGE',"<div class=\"notice notice-error is-dismissible\"> <p>" . $message . "</p> </div>", $result );
        goto action;
    }
    // Thực hiện thêm các đoạn code xử lý purge cache phía Web server vào Nukeviet
    removePurgeCacheHandle($message);
    if(addPurgeCacheHandle($message)) {
        try {
            $query = "UPDATE " . $db_config['prefix'] . "_" . $module_data . "_config SET config_value='1' WHERE config_name='fix_purge_cache'";
            $row = $db->prepare($query);
            $row->execute();
        } catch( PDOException $e ) {
            trigger_error( $e->getMessage() );
        }
    }
    else {
        $xtpl->assign( 'MESSAGE',"<div class=\"notice notice-error is-dismissible\"> <p>" . $message . "</p> </div>", $result );
        goto action;
    }
    // Khởi tạo cookie đầu tiên bởi admin đã login từ trước.
    $nv_Request->set_Cookie('adlogin', '1');

    // Cập nhật first_run = 1 để lần sau không thực hiện công việc trên
    try {
            $query = "UPDATE " . $db_config['prefix'] . "_" . $module_data . "_config SET config_value='1' WHERE config_name='first_run'";
            $row = $db->prepare($query);
            $row->execute();
        } catch( PDOException $e ) {
            trigger_error( $e->getMessage() );
    }
}

action:
/*
    Lấy biến $action từ URL
*/
$action = $nv_Request->get_title('action', 'get');

/*
    Kiểm tra giá trị của action và thực hiện các hành động tương ứng
*/
switch ($action) {
    // $action = enableCache : Thực hiện bật Cache cho Nukeviet
    case "enableCache":
        // Để trách bị lặp rewrite, thực hiện tắt rewrite cache trước sau đó mới bật rewrite cache
        disableCacheRewrite($message);
        if(enableCacheRewrite($publicCacheTTL, $frontPageCacheTTL, $cacheLoginPage, $cacheFavicon ,$message)) {
            $result = "success"; 
           try {
                $query = "UPDATE " . $db_config['prefix'] . "_" . $module_data . "_config SET config_value='1' WHERE config_name='cache_status'";
                $row = $db->prepare($query); 
                $row->execute();
             } catch( PDOException $e ) {
                trigger_error( $e->getMessage() );
            }

        } else
            $result = "error";

        $xtpl->assign( 'MESSAGE',"<div class=\"notice notice-" . $result . " is-dismissible\"> <p>" . $message . "</p> </div>", $result );
        break;
    // Tắt Cache.
    case "disableCache":
        if(disableCacheRewrite($message)) {
            $result = "success";
            try {
                $query = "UPDATE " . $db_config['prefix'] . "_" . $module_data . "_config SET config_value='0' WHERE config_name='cache_status'";
                $row = $db->prepare($query); 
                $row->execute();
             } catch( PDOException $e ) {
                trigger_error( $e->getMessage() );
            }
        }
           
        else
            $result = "error";
        $xtpl->assign( 'MESSAGE',"<div class=\"notice notice-" . $result . " is-dismissible\"> <p>" . $message . "</p> </div>", $result );
        break;
     // Kiểm tra tương thích hệ thống
     case "checkRequirement":
        if(checkRequirement($global_config['version'],$message))
            $result = "success";
        else
            $result = "error";
        $xtpl->assign( 'MESSAGE',"<div class=\"notice notice-" . $result . " is-dismissible\"> <p>" . $message . "</p> </div>", $result );
        break;
 
    // Chỉ dành cho debug. 
    case "initCache":
        removeCookieHandle($message);
        if(addCookieHandle($message)) {
            $result = "success";
            try {
                $query = "UPDATE " . $db_config['prefix'] . "_" . $module_data . "_config SET config_value='1' WHERE config_name='fix_cookie'";
                $row = $db->prepare($query); 
                $row->execute();
             } catch( PDOException $e ) {
                trigger_error( $e->getMessage() );
            }
        }
        else
            $result = "error";
        $xtpl->assign( 'MESSAGE',"<div class=\"notice notice-" . $result . " is-dismissible\"> <p>" . $message . "</p> </div>", $result );
        break;
    // Xóa cache trang chủ. Xóa URL = / và URL = /lang (ví dụ /vi/)
    case "purgeFront":
        $url = NV_BASE_SITEURL;
        $urlWithLang = NV_BASE_SITEURL . NV_LANG_DATA . "/";
        if (sendPurge($url, FALSE, $message ) && sendPurge($urlWithLang, FALSE, $message )) {
            $result = "success";
            $xtpl->assign( 'MESSAGE',"<div class=\"notice notice-" . $result . " is-dismissible\"> <p> " . $lang_module['123host_purge_front_success'] . " </p> </div>", $result );
        } else {
            $result = "error";
            $xtpl->assign( 'MESSAGE',"<div class=\"notice notice-" . $result . " is-dismissible\"> <p> " . $lang_module['123host_purge_front_failure'] . "</p> </div>", $result );
        }
        break;
    // Xóa tất cả cache
    case "purgeAll":
        $nv_Cache->sendPurgeLSCache();
        $xtpl->assign( 'MESSAGE',"<div class=\"notice notice-success is-dismissible\"> <p>" . $lang_module['123host_purge_success'] . "</p> </div>");
        break;
    
}

// Lấy trạng thái cache hiện tại (đang bật hay tắt)
try {
    $query = "SELECT config_value FROM " . $db_config['prefix'] . "_" . $module_data . "_config WHERE config_name='cache_status'";
    $row = $db->query($query)->fetch();
    $cacheStatus = $row['config_value'];
} catch( PDOException $e ) {
    trigger_error( $e->getMessage() );
}

// Đưa vào view button và trạng thái cache cho phù hợp
if ($cacheStatus == '0') {
     $xtpl->assign( 'CACHE_STATUS',"<h3><em class='fa fa-lg fa-exclamation-triangle text-danger' >&nbsp;</em> ". $lang_module['123host_status_disable'] ." </h3>");
     $xtpl->assign( 'CACHE_BUTTON',"<a href='" . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=main' . '&amp;' . 'action=enableCache' . "' class='litespeed-btn litespeed-btn-primary'> " . $lang_module['123host_enable_cache'] . " </a>");
} else {
    $xtpl->assign( 'CACHE_STATUS',"<h3><em class='fa fa-lg fa-check text-success' >&nbsp;</em>" . $lang_module['123host_status_enabled']. "</h3>");
    $xtpl->assign( 'CACHE_BUTTON',"<a href='" . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=main' . '&amp;' . 'action=disableCache' . "' class='litespeed-btn litespeed-btn-warning'> ". $lang_module['123host_disable_cache'] ." </a>");
}

// Đưa vào view button Xóa Cache Trang chủ và Xóa tất cả Cache. URL được tùy biến theo ngôn ngữ và đường dẫn riêng của Nukeviet.
$xtpl->assign( 'PURGE_CACHE_FRONT_BUTTON',"<a href='" . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=main' . '&amp;' . 'action=purgeFront' . "' class='litespeed-btn litespeed-btn-success'>". $lang_module['123HOST_MAIN_TL3'] . " </a>");
$xtpl->assign( 'PURGE_CACHE_ALL_BUTTON',"<a href='" . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=main' . '&amp;' . 'action=purgeAll' . "' class='litespeed-btn litespeed-btn-danger'>". $lang_module['123HOST_MAIN_TL6'] . " </a>");

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

$page_title = $lang_module['main'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';
