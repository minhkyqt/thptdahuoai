<?php

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE')) {
    die('Stop!!!');
}

$module_version = array(
    'name' => 'Thời khóa biểu',
    'modfuncs' => 'main,giaovien',
    'submenu' => 'main,giaovien',
    'is_sysmod' => 0,
    'virtual' => 1,
    'version' => '4.2.01',
    'date' => 'Sat, 5 Aug 2017 13:00:00 GMT',
    'author' => 'quocdatit <admin@quocdatit.com>',
    'note' => '',
    'uploads_dir' => array(
        $module_upload
    )
);