<?php

if (!defined('NV_ADMIN'))
    die('Stop!!!');

$submenu['import_lop'] = $lang_module['import_lop'];
$submenu['import_giaovien'] = $lang_module['import_giaovien'];
$submenu['config'] = $lang_module['config'];

$allow_func[] = 'main';
$allow_func[] = 'import_lop';
$allow_func[] = 'import_giaovien';
$allow_func[] = 'config';