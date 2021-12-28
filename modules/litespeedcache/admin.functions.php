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

if ( ! defined( 'NV_ADMIN' ) or ! defined( 'NV_MAINFILE' ) or ! defined( 'NV_IS_MODADMIN' ) ) die( 'Stop!!!' );

define( 'NV_IS_FILE_ADMIN', true );


$allow_func = array( 'main', 'config', 'info', 'init' );
// Document
$array_url_instruction['main'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=info#cache_management';
$array_url_instruction['config'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=info#config';
/*
    Function kiểm tra tính tương thích của hệ thống:
        - Kiểm tra phiên bản Nukeviet: Phải là Nukeviet 4.0 trở lên
        - Các file cần thiết phải tồn tại và ghi được
*/
function checkRequirement($nvCurrentVersion,&$message) {
    global $lang_module;
    $system_ok = TRUE;
    // Nukeviet versions are supported
    $arrayVersion = explode('.', $nvCurrentVersion);
    if ($arrayVersion[0] != 4 && $arrayVersion[0] != 1) {
        $message = $lang_module['123host_version_error'];
        return FALSE;
    }
    // Files must exist and writeable
    $filesNeedToWrite = array (
        NV_ROOTDIR . '/.htaccess',
        NV_ROOTDIR . '/includes/core/admin_login.php',
        NV_ROOTDIR . '/includes/core/admin_logout.php',
        NV_ROOTDIR . '/vendor/vinades/nukeviet/Cache/Files.php'
    );
    $htaccessFile = NV_ROOTDIR . '/.htaccess';
    $adminLogin = NV_ROOTDIR . '/includes/core/admin_login.php';
    $adminLogout = NV_ROOTDIR . '/includes/core/admin_logout.php';

    foreach ($filesNeedToWrite as $file) {
        if (!is_writable($file)) {
            $message = $message . "<br><i>" . 'File <strong>' . $file . '</strong>' . $lang_module['123host_file_not_exist_or_write'] . '</i>';
	    $system_ok = FALSE;
        }
    }
    if ($system_ok === FALSE) {
        $message = $message . $lang_module['123host_system_not_meet'];
        return FALSE;
    } else {
    	if(isset($_SERVER['SERVER_SOFTWARE'])) {
		$server_software = $_SERVER['SERVER_SOFTWARE'];
		if(strpos("LiteSpeed", $server_software) === FALSE)
            		$message = $message . "<br><i>" . $lang_module['123host_your_web_server_is'] . "<b>" . $server_software. "</b>. " . $lang_module['123host_web_server_not_suported'] . '</i> <br>';
    	}
        $message = $lang_module['123host_system_meet'];
        return TRUE;
    }
}

/*
    Build rewrite rule và Bật rewrite cache tại file .htaccess
*/
function enableCacheRewrite($publicCacheTTL, $frontPageCacheTTL, $cacheLoginPage, $cacheFavicon ,&$message) {
    global $lang_module;
    $htaccessFile = NV_ROOTDIR . '/.htaccess';

    if ($cacheLoginPage == 1) {
        $cacheLoginPageBlock = "";
    } else {
        $cacheLoginPageBlock = "\n  ### LiteSpeed Cache - LOGIN LOCATION\n  RewriteCond %{ORG_REQ_URI} !/admin|/users [NC]\n  ### LiteSpeed Cache - LOGIN LOCATION
    ";
    }

    if ($cacheFavicon == 1) {
        $cacheFaviconBlock = "";
    } else {
        $cacheFaviconBlock = "### LiteSpeed Cache - FAVICON\n  RewriteCond %{REQUEST_URI} !/favicon\.ico$ [NC]\n  ### LiteSpeed Cache - FAVICON
    ";
    }


    // Create rewrite content for handle caching
    $rewriteContent = "########## Begin LiteSpeed Cache
## This content generated by LiteSpeed Cache - Do not edit the contents of this block! ##
<IfModule LiteSpeed>
  RewriteEngine On
  CacheDisable public /

  ### LiteSpeed Cache - HTTP METHOD
  RewriteCond %{REQUEST_METHOD} ^HEAD|GET|PURGE$
  ### 123HOST - HTTP METHOD

  ### LiteSpeed Cache - INDEX
  RewriteCond %{REQUEST_URI} !^/index.php
  ### LiteSpeed Cache - INDEX

  ### LiteSpeed Cache - SHOP MODULE
  RewriteCond %{REQUEST_URI} !cart|order|payment
  ### LiteSpeed Cache - SHOP MODULE

  ### LiteSpeed Cache - MOBILE
  RewriteCond %{HTTP_USER_AGENT} \"android|avantgo|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge\ |maemo|midp|mmp|opera\ m(ob|in)i|palm(\ os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows\ (ce|phone)|xda|xiino\" [NC]
  RewriteRule .* - [E=Cache-Control:vary=ismobile]
  ### LiteSpeed Cache - MOBILE
  " . $cacheLoginPageBlock . "
  " . $cacheFaviconBlock . "
  ### LiteSpeed Cache - LOGIN COOKIE
  RewriteCond %{HTTP_COOKIE} !nvloginhash|adlogin [NC]
  ### LiteSpeed Cache - LOGIN COOKIE

  ### LiteSpeed Cache - MAX AGE
  RewriteRule .* - [E=Cache-Control:max-age=" . $publicCacheTTL . "] [NC]
  ### LiteSpeed Cache - MAX AGE

</IfModule>
########## End - LiteSpeed Cache\n";

    $oldRewriteContent = file_get_contents($htaccessFile);
    $newRewriteContent = $rewriteContent . $oldRewriteContent;

    // Append content to .htaccess file
    if (file_put_contents($htaccessFile, $newRewriteContent, LOCK_EX)) {
        $message =  $lang_module['123host_enable_cache_success'] . sprintf($lang_module['123host_check_cache_enable_here'], "https://123host.vn/tool/is_lscache_ok?url=". NV_MY_DOMAIN);
	if(isset($_SERVER['LSWS_EDITION']) && strpos($_SERVER['LSWS_EDITION'],"Openlitespeed") !== FALSE) {
        	$message = $message. " <br>" . $lang_module['123host_notice_open_litespeed_need_restart_to_enable_cache'];
    	}
        return TRUE;
    } 
    else {
        $message = $lang_module['123host_enable_cache_failure'];
        return FALSE;
    }

}

function filePutContentWithPattern($file, $pattern, $content, $line, &$message) {
         
    global $lang_module;
    if ( !is_writable($file) ) {
        $message = 'File <strong>' . $file . '</strong> ' . $lang_module['123host_file_not_exist_or_write'];
        return FALSE;
    }
    $contentByLine = file($file);
    $i = 0;
    foreach ( $contentByLine as $lineNum => $lineContent ) {
        if ( preg_match($pattern, $lineContent) ) {

            $insertLineNum = $lineNum + $line + $i;

            array_splice( $contentByLine, $insertLineNum, 0, $content ); 

            if ( !file_put_contents($file, implode("", $contentByLine), LOCK_EX) ) {

                $message = 'File <strong>' . $file . '</strong> ' . $lang_module['123host_file_not_exist_or_write'];

                return FALSE;
            }
            $i = $i + 1; 
        }
    }

    return TRUE;
}

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
        $message = $lang_module['123host_disable_cache_success'] .  sprintf($lang_module['123host_check_cache_disable_here'], "https://123host.vn/tool/is_lscache_ok?url=". NV_MY_DOMAIN);
	if(isset($_SERVER['LSWS_EDITION']) && strpos($_SERVER['LSWS_EDITION'],"Openlitespeed") !== FALSE) {
                $message = $message. " <br>" . $lang_module['123host_notice_open_litespeed_need_restart_to_disable_cache'];
        }
        return TRUE;
    } else {
        $message = $lang_module['123host_disable_cache_failure'] . " <a href='" . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=litespeedcache&amp;' . NV_OP_VARIABLE . '=main' . '&amp;' . 'action=checkRequirement' . "'>"  . $lang_module['123host_check_check_req']  . "</a>";
        return FALSE;
    }
}


/*
    Fix các file admin_login.php và admin_logout.php để hỗ trợ cache cho Nukeviet
    Hỗ trợ module Shops
*/
function addCookieHandle(&$message) {
    global $lang_module;

    $adminLoginFile = NV_ROOTDIR . '/includes/core/admin_login.php';
    $adminLogoutFile = NV_ROOTDIR . '/includes/core/admin_logout.php';
    $shopSetCartFile = NV_ROOTDIR . '/modules/shops/funcs/setcart.php';

    $adminLoginPattern = "/admin\_lev\ \=\ intval|row\[\'admin\_lev\'\]\ \=\ intval/";
    $shopSetCartPattern = "/update\_cart\ \=\ true/";
    
    $adminLogoutPattern = "/unset\_request\(\'admin\,online/";

    $setCookie = array("//LiteSpeed Cache begin add cookie\n\$nv_Request->set_Cookie('adlogin', '1');\n//LiteSpeed Cache end add cookie\n");

    $removeCookie = array("//LiteSpeed Cache begin remove cookie\n\$nv_Request->unset_request('adlogin', 'cookie');\n//LiteSpeed Cache end remove cookie\n");

    /* Module shop support. Insert code to create cookie after add item to cart */
    filePutContentWithPattern($shopSetCartFile, $shopSetCartPattern, $setCookie, 1, $message);

    /* Insert code to create cookie after admin login */
    /* Insert code to remove cookie after admin logout */
    if ( filePutContentWithPattern($adminLoginFile, $adminLoginPattern, $setCookie,1 , $message) 
    && filePutContentWithPattern($adminLogoutFile, $adminLogoutPattern, $removeCookie, 1, $message) ) {
        $message = $lang_module['123host_init_cache_success'];
        return TRUE;
    } else {
        return FALSE;
    }
    
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

/*
    Fix file vendor/vinades/nukeviet/Cache/Files.php để hỗ trợ call đến purge cache lúc có sự thay đổi trên hệ thống (như đăng bài, sửa bài, sửa module)
*/
function addPurgeCacheHandle(&$message) {
    global $lang_module;
    
    $cacheFile = NV_ROOTDIR . '/vendor/vinades/nukeviet/Cache/Files.php';

    $patternForAddFunction = "/}/";
    $patternForCallFunction = "/delAll|delMod/";
    
    $contentFunction = array("//LiteSpeed Cache begin mofidy\npublic function sendPurgeLSCache() {\n        @Header('X-LiteSpeed-Purge: *');
}\n//LiteSpeed Cache end mofidy\n");
    $contentCallFunction = "//LiteSpeed Cache begin mofidy\n        \$this->sendPurgeLSCache();\n//LiteSpeed Cache end mofidy\n";
    
    // Thêm function sendPurgeLSCache vào cuối file Files.php
    $contentByLine = file($cacheFile);

    foreach ( $contentByLine as $lineNum => $lineContent ) {
        if (preg_match($patternForAddFunction, $lineContent) ) {
            $insertLineNum = $lineNum;
        }
    }
        
    array_splice( $contentByLine, $insertLineNum, 0, $contentFunction ); 
        
    if(!file_put_contents($cacheFile, implode("", $contentByLine), LOCK_EX)){
        $message = $lang_module['123host_edit_file_failure'] . $cacheFile;
        return FALSE;
    }

    // Thêm $this->sendPurgeLSCache() sau function delMod và delAll
    if (filePutContentWithPattern($cacheFile, $patternForCallFunction, $contentCallFunction, 2, $message) ) {
        $message = $lang_module['123host_edit_file'] . $cacheFile . $lang_module['123host_success'];
        return TRUE;
    } else {
        $message = $lang_module['123host_edit_file_failure'] . $cacheFile;
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
   Build header và Gởi thông tin xóa cache đến web server
   Lưu ý: Chỉ hỗ trợ web server của 123HOST
*/
function sendPurge($url, $debug = FALSE, &$message) {
        
    $fp = fsockopen(NV_SERVER_NAME, 80, $errno, $errstr, 2);
    if (!$fp) {
        $message = "$errstr ($errno)\n";
        return FALSE;
    } else {
        $out = "PURGE ". $url ." HTTP/1.0\r\n"
        . "Host: " . NV_SERVER_NAME . "\r\n"
        . "Connection: Close\r\n\r\n";
        fwrite($fp, $out);
        if ($debug) {
            $message = $out;
            while (!feof($fp)) {
                $message = $message . "<br>" . fgets($fp, 128);
            }
        }
        fclose($fp);
        return TRUE;
    }
}