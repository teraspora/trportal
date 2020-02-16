<?php

// Template/Users/export.ctp
echo "#ID,Number,Country,Start time,Connect time,End time,Score,URL\n";
foreach ($data as $result):
    // foreach ($row as &$cell):
    //     // Escape double quotation marks
    //     $cell = '"' . preg_replace('/"/', '""', $cell) . '"';
    // endforeach;
    $idstr = $result->get('job_processing_uid')
                . '_' . $result->get('test_counter')
                . '_' . $result->get('test_type_uid');
    $number = $result->get('number');
    $country = $result->get('country');
    $times = $result->get('start_time')->i18nFormat('yyyy-MM-dd HH:mm:ss')
            . ',' . $result->get('connect_time')->i18nFormat('yyyy-MM-dd HH:mm:ss'
            . ',' . $result->get('end_time')->i18nFormat('yyyy-MM-dd HH:mm:ss');
    $score = number_format($result->get('score'), 2);
    $url = $result->get('url');
    $csv_row = $idstr . ',' . $number . ',' . $country . ',' . $times . ',' . $score . ',' . $url;
    echo $csv_row . "\n";
endforeach;
