<?php

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE') or !defined('NV_IS_MODADMIN')) {
    die('Stop!!!');
}

define('NV_IS_TKB_ADMIN', true);

function _array_shift(&$data, $num = 2) {
	for ($i=0; $i < $num; $i++) { 
		array_shift($data);
	}
}