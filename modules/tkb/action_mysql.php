<?php

if (!defined('NV_IS_FILE_MODULES'))
    die('Stop!!!');
 
 
$sql_drop_module = array();
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_lop";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_giaovien";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config";

$sql_create_module = $sql_drop_module;
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_lop (
lop VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
tiet MEDIUMINT( 2 ) NOT NULL ,
buoi MEDIUMINT( 2 ) NOT NULL ,
thu2 VARCHAR( 150 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
thu3 VARCHAR( 150 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
thu4 VARCHAR( 150 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
thu5 VARCHAR( 150 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
thu6 VARCHAR( 150 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
thu7 VARCHAR( 150 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL 
)ENGINE=MyISAM  DEFAULT CHARSET=utf8";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_giaovien (
giaovien VARCHAR( 150 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
tiet MEDIUMINT( 2 ) NOT NULL ,
buoi MEDIUMINT( 2 ) NOT NULL ,
thu2 VARCHAR( 150 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
thu3 VARCHAR( 150 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
thu4 VARCHAR( 150 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
thu5 VARCHAR( 150 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
thu6 VARCHAR( 150 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
thu7 VARCHAR( 150 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL 
)ENGINE=MyISAM  DEFAULT CHARSET=utf8";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config (
cfg_name VARCHAR( 150 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL PRIMARY KEY ,
cfg_value TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL
)ENGINE=MyISAM  DEFAULT CHARSET=utf8";

$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config (cfg_name, cfg_value) VALUES ('day_apply', '".date("d/m/Y", strtotime('next monday'))."')";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config (cfg_name, cfg_value) VALUES ('title_tkb_lop', 'THỜI KHÓA BIỂU LỚP')";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config (cfg_name, cfg_value) VALUES ('title_tkb_gv', 'THỜI KHÓA BIỂU GIÁO VIÊN')";