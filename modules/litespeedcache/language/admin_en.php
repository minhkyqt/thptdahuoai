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

$lang_translator['author'] = '123host (tanviet@123host.vn)';
$lang_translator['createdate'] = '11/08/2017, 09:48';
$lang_translator['copyright'] = '@Copyright (C) 2017 123host All rights reserved';
$lang_translator['info'] = '';
$lang_translator['langtype'] = 'lang_module';

$lang_module['main'] = 'Main';
$lang_module['config'] = 'Setting';
$lang_module['save'] = 'Save';
$lang_module['manage'] = 'Manage';
$lang_module['info'] = 'Information';

$lang_module['123HOST_MAIN_INTRO'] = 'From this screen, one can inform the server to purge the selected cached pages or empty the entire cache.';
$lang_module['123HOST_MAIN_TL2'] = 'Purge the Front Page';
$lang_module['123HOST_MAIN_TL3'] = 'Purge Front Page';
$lang_module['123HOST_MAIN_TL4'] = 'This will Purge Front Page only';
$lang_module['123HOST_MAIN_TL5'] = 'Clear all cache entries';
$lang_module['123HOST_MAIN_TL6'] = 'Empty Entire Cache';
$lang_module['123HOST_MAIN_TL7'] = 'Clears all cache entries related to this site, <i>including other web applications</i>.';
$lang_module['123HOST_MAIN_PURGE_SUCCESS'] = 'Notified 123HOST Web Server to purge cache';

$lang_module['123host_purge_front_success'] = "Notified Web Server to purge the front page";
$lang_module['123host_purge_front_failure'] = "Failed to purge cache";
$lang_module['123host_purge_success'] = "Notified Web Server to purge all cache";
$lang_module['123host_status_enabled'] = "ENABLED";
$lang_module['123host_status_disable'] = "DISABLED";
$lang_module['123host_enable'] = "Enable";
$lang_module['123host_disable'] = "Disable";
$lang_module['123host_enable_cache'] = "Enable Cache";
$lang_module['123host_disable_cache'] = "Disable Cache";
$lang_module['123host_settings_saved'] = "Settings saved";
$lang_module['123host_version_error'] = "This module only supports Nukeviet version 4.0 or higher or Nukeviet Egov 1.0 or higher. Please contact support@123host.vn for more information!";
$lang_module['123host_file_not_exist_or_write'] = " does not exist or does not have write permission.";
$lang_module['123host_your_web_server_is'] = "Your web server is ";
$lang_module['123host_web_server_not_suported'] = "For Cache feature to work, web server must be <b> LiteSpeed </b> or <b> OpenLiteSpeed </b> ";
$lang_module['123host_system_not_meet'] = "The system does not meet the requirements. The cache module may fail to start or not function properly!";
$lang_module['123host_notice_open_litespeed_need_restart_to_enable_cache'] = "Your server is using <b>OpenLiteSpeed</b> web server, please restart OpenLiteSpeed to update .htacess file. <b>Enable Cache</b> feature will work after restart web server!</b>";
$lang_module['123host_notice_open_litespeed_need_restart_to_disable_cache'] = "Your server is using <b>OpenLiteSpeed</b> web server, please restart OpenLiteSpeed to update .htacess file. <b>Disable Cache</b> feature will work after restart web server!</b>";
$lang_module['123host_system_meet'] = "Congratulations. The system meets all requirements!";
$lang_module['123host_enable_cache_success'] = "Enable Cache successfully";
$lang_module['123host_enable_cache_failure'] = "Error during enable Caching. Please make sure the .htaccess file has write permission!";
$lang_module['123host_disable_cache_success'] = "Disable Cache successfully";
$lang_module['123host_disable_cache_failure'] = "Error during cache turned off!";
$lang_module['123host_check_cache_enable_here'] = "<br> You can check if your website is cached by LiteSpeed <a href='%s' target='_blank'> here </a>.";
$lang_module['123host_check_cache_disable_here'] = "<br> You can check if your website has really turned off the cache <a href='%s' target='_blank'> here </a>.";
$lang_module['123host_check_check_req'] = "Click here to check the compatibility of the system!";
$lang_module['123host_init_cache_success'] = "Cache initialization success!";
$lang_module['123host_init_cache_failure'] = "Initialize Cache failure!";
$lang_module['123host_edit_file_failure'] = "Error: Can not edit file ";
$lang_module['123host_edit_file'] = "Edit file ";
$lang_module['123host_success'] = " success!";
$lang_module['123host_not_at_123host'] = "This module only support with Hosting at <a href='https://123host.vn/' target='_blank'>123HOST</a>. Please use <a href='https://123host.vn/nukeviet-hosting.html' target='_blank'> Nukeviet Hosting </a> at <a> 123HOST </a> for best support and amazing speed for Nukeviet Website.";
$lang_module['123host_general_config'] = "General configuration";
$lang_module['123host_specific_pages'] = "Specific Pages";
$lang_module['123host_information'] = "Information";
$lang_module['123host_public_cache_ttl'] = "Default Public Cache TTL";
$lang_module['123host_public_cache_ttl_des'] = "Specify how long, in seconds, public pages are cached. Minimum is 30 seconds.	Recommended value: 604800.";
$lang_module['123host_front_cache_ttl'] = "Default Front Page TTL";
$lang_module['123host_front_cache_ttl_des'] = "Specify how long, in seconds, the front page is cached. Minimum is 30 seconds.	Recommended value: 604800.";
$lang_module['123host_cache_login_page'] = "Enable Cache for Login Page	";
$lang_module['123host_cache_login_page_des'] = "Option to disable or enable Cache for admin and user login pages.";
$lang_module['123host_cache_favicon'] = "Cache favicon.ico";
$lang_module['123host_cache_favicon_des'] = "favicon.ico is requested on most pages.	Caching this recource may improve server performance by avoiding unnecessary PHP calls.";
$lang_module['123host_cache_statuss'] = "Cache Status";
$lang_module['123host_cache_action'] = "Enable or Disable Cache";
$lang_module['123host_about_module'] = "About";
$lang_module['123host_about_module_des1'] = "<p>This module is developed by <a href=\"https://123host.vn/\" target=\"_blank\">123HOST</a> for <a href=\"https://123host.vn/nukeviet-hosting.html\" target=\"_blank\">Nukeviet Hosting</a> . A premium Hosting Service for Nukeviet CMS
. Purpose:</p>
<ol>
    <li><strong>Speed Up Nukeviet websites with caching technology at Web Server:</strong></li>
    <br>
    <li><strong>Reduce RAM, CPU usage of server</strong></li>
</ol>";

$lang_module['123host_faqs'] = "FAQs";
$lang_module['123host_faq_q1'] = "Who develops this module?";
$lang_module['123host_faq_a1'] = "<p><a href=\"https://123host.vn/\" target=\"_blank\">123HOST</a> develops this module.</p>";
$lang_module['123host_faq_q2'] = "How does this module work?";
$lang_module['123host_faq_a2'] = "<p>This module is an interface for controlling the cache on the <strong>Web Server</strong/>. Key features:</p>
<ol>
    <li>Enable / Disable Cache</li>
    <li>Configure Cache TTL</li>
    <li>Purge Cache</li>
</ol>";
$lang_module['123host_faq_q3'] = "What is Cache (Web Cache)?";
$lang_module['123host_faq_a3'] = "<p>A <strong>Web cache</strong> (or HTTP cache) is an information technology for the temporary storage (caching) of web documents, such as HTML pages and images, to reduce bandwidth usage, server load, and perceived lag. A web cache system stores copies of documents passing through it; subsequent requests may be satisfied from the cache if certain conditions are met.</p>";

$lang_module['123host_faq_q4'] = "Using Hosting at other Hosting Provider can you use this module?";
$lang_module['123host_faq_a4'] = "<p>No, This module only supported by <a href=\"https://123host.vn/nukeviet-hosting.html\" target=\"_blank\">Hosting Services</a> at 123HOST.VN</p>";

$lang_module['123host_faq_q5'] = "I am using VPS service at 123HOST. Can I use this module?";
$lang_module['123host_faq_a5'] = "<p>Sorry, this module is not yet supported for VPS. Only compatible with <a href=\"https://123host.vn/nukeviet-hosting.html\" target=\"_blank\">Nukeviet Hosting</a></p>";

$lang_module['123host_faq_q6'] = "What version of Nukeviet is supported?";
$lang_module['123host_faq_a6'] = "<p>The current module only support Nukeviet 4</p>";

$lang_module['123host_cache_management'] = "Cache Management";
$lang_module['123host_cache_management_des1'] = "<p> This feature is in the <strong>Cache Management</strong> menu. Here, the administrator can:</p>
<ul>
    <li><strong>Check Cache status</strong></li>
    <li><strong>Enable or Disable Cache:</strong></li>
    <li><strong>Purge front page Cache:</strong></li>
    <li><strong>Purge all Cache:</strong></li>
</ul>
<p>Whenever a page is updated, the cache is automatically notified and the page cleared so that no one is served an out-of-date page.</p>";
$lang_module['123host_general_config_des1'] = "<ul>
<li><strong>Default Public Cache TTL:</strong> Set on a per store basis. Determines how long (in seconds) public cached pages and data are stored for. The recommended value is 86400.</li>
<li><strong>Default Front Page TTL:</strong> Determines how long (in seconds) the home page is stored for. Use this setting to specify a different TTL for the home page.
By default, this setting will use the Default Public Cache TTL setting's value.
</li>
</ul>";
$lang_module['123host_specific_pages'] = "Specific Pages";
$lang_module['123host_specific_pages_des1'] = "<ul>
<li><strong>Enable Cache for Login Page:</strong> This option will cache the login page. Normally, there is no reason to uncheck this option. However, if there is something that may identify a user on the page, this should be unchecked.
</li>
<li><strong>Cache favicon.ico:</strong> This option will cache the favicon.ico response if it does not exist. The reason for caching this is because if the file does not exist, it will load Nukeviet every time. This will avoid that extra call.
</li>
</ul>";

$lang_module['123host_check_requirement'] = "Check the compatibility of the system.";

$lang_module['123host_check_requirement_des1'] = " to perform a system compatibility check.";
$lang_module['123host_support_info'] = "Support information";
$lang_module['123host_support_info_des1'] = "<h4>Please contact us:</h4>
<ul>
    <li><strong>Email:</strong> support@123host.vn</li><br>
    <li><strong>SDT: 02873 002 123</strong> support@123host.vn</li><br>
    <li><strong>Ticket:</strong> <a href=\"https://client.123host.vn/?/tickets/new/&dept_id=1\" target=\"_blank\"> Submit a ticket</a></li>
</ul>";

$lang_module['123host_check_compatibility'] = "Check Compatibility";
$lang_module['123host_seconds'] = "seconds";
$lang_module['123host_click_here'] = "Click here";
