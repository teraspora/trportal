<?php

// Template/Users/export.ctp

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
    $times = $result->get('start_time') . ',' . $result->get('connect_time') . ',' . $result->get('end_time');
    $score = number_format($result->get('score'), 2);
    $url = $result->get('url');
    $csv_row = $idstr . ',' . $number . ',' . $country . ',' . $times . ',' . $score . ',' . $url;
    echo $csv_row . "\n";
endforeach;