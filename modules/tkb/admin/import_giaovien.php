<?php

if (!defined('NV_IS_TKB_ADMIN')) {
    die('Stop!!!');
}

// include dirname(__FILE__) . '/../plugins/PHPExcel/Classes/PHPExcel/IOFactory.php';
include dirname(__FILE__) . '/../plugins/PHPExcel/IOFactory.php';
$page_title = $lang_module['import_giaovien'];
$error = '';
$success = '';

// Khi nhấp Import
if ($nv_Request->isset_request('do', 'post')) {
    $buoi = $nv_Request->get_int('buoi', 'post', 0);

    if (
        isset($_FILES['ufile']) &&
        is_uploaded_file($_FILES['ufile']['tmp_name'])
    ) {
        $filename = nv_string_to_filename($_FILES['ufile']['name']);
        $file = NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $filename;
        if (file_exists($file)) {
            unlink($file);
        }
        if (move_uploaded_file($_FILES['ufile']['tmp_name'], $file)) {
            if (file_exists($file)) {
                try {
                    $fileType = PHPExcel_IOFactory::identify($file);
                    $objReader = PHPExcel_IOFactory::createReader($fileType);
                    $objPHPExcel = $objReader->load($file);
                } catch (Exception $e) {
                    $error =
                        $lang_module['error_cannot_read_file'] .
                        ' ' .
                        pathinfo($file, PATHINFO_BASENAME) .
                        '": ' .
                        $e->getMessage();
                }

                if (empty($error)) {
                    $sheet = $objPHPExcel->getSheet(0);
                    $highestRow = $sheet->getHighestRow();
                    $highestColumn = $sheet->getHighestColumn();

                    $data = [];
                    $list_gv = [];
                    for ($row = 1; $row <= $highestRow; $row++) {
                        $dataRow = $sheet->rangeToArray(
                            'A' . $row . ':' . $highestColumn . $row,
                            null,
                            true,
                            false
                        );
                        $list_gv[] = $dataRow[0][0];
                        $data[] = $dataRow;
                    }
                    _array_shift($data, 2);
                    _array_shift($list_gv, 2);
                    $data_import = [];
                    foreach ($data as $_gv => $row) {
                        $thu = 2;
                        $tiet = 1;
                        _array_shift($row[0], 1);
                        foreach ($row[0] as $_k => $lop) {
                            $data_import[$list_gv[$_gv]][$tiet][$thu] = $lop;
                            $tiet++;
                            if ($_k % 5 == 4) {
                                $tiet = 1;
                                $thu++;
                            }
                        }
                    }

                    // Bắt đầu import vào database
                    foreach ($data_import as $_gv => $val1) {
                        $db->query(
                            'DELETE FROM ' .
                                NV_PREFIXLANG .
                                '_' .
                                $module_data .
                                "_giaovien WHERE giaovien = '" .
                                $_gv .
                                "' AND buoi = " .
                                $buoi
                        );
                        foreach ($val1 as $_tiet => $_lop) {
                            $_sql =
                                'INSERT INTO ' .
                                NV_PREFIXLANG .
                                '_' .
                                $module_data .
                                '_giaovien
								(giaovien, tiet, buoi, thu2, thu3, thu4, thu5, thu6, thu7) VALUES
								(:giaovien, :tiet, :buoi, :thu2, :thu3, :thu4, :thu5, :thu6, :thu7)';

                            $sth = $db->prepare($_sql);
                            $sth->bindParam(':giaovien', $_gv, PDO::PARAM_STR);
                            $sth->bindParam(':tiet', $_tiet, PDO::PARAM_INT);
                            $sth->bindParam(':buoi', $buoi, PDO::PARAM_INT);

                            foreach ($_lop as $_thu => $_nocare) {
                                $sth->bindParam(
                                    ':thu' . $_thu,
                                    $_lop[$_thu],
                                    PDO::PARAM_STR
                                );
                            }
                            $sth->execute();
                        }
                    }
                    $success = $lang_module['import_success'];
                    unlink($file);
                }
            } else {
                $error = $lang_module['error_upload_file'];
            }
        } else {
            $error = $lang_module['error_upload_file'];
        }
    } else {
        $error = $lang_module['error_dont_have_file'];
    }
}

$action =
    NV_BASE_ADMINURL .
    'index.php?' .
    NV_LANG_VARIABLE .
    '=' .
    NV_LANG_DATA .
    '&amp;' .
    NV_NAME_VARIABLE .
    '=' .
    $module_name .
    '&amp;' .
    NV_OP_VARIABLE .
    '=' .
    $op;

// Hiển thị
$xtpl = new XTemplate(
    'import_giaovien.tpl',
    NV_ROOTDIR .
        '/themes/' .
        $global_config['module_theme'] .
        '/modules/' .
        $module_file
);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('FORM_ACTION', $action);

if ($error) {
    $xtpl->assign('ERROR', $error);
    $xtpl->parse('main.error');
}

if ($success) {
    $xtpl->assign('SUCCESS', $success);
    $xtpl->parse('main.success');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';