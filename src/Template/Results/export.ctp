<?php

echo "#ID,Number,Country,Start time,Connect time,End time,Score,URL";
foreach ($data as $result):
    $idstr = $result->get('job_processing_uid')
                . '_' . $result->get('test_counter')
                . '_' . $result->get('test_type_uid');
    $number = $result->get('number');
    $country = $result->get('country');
    $times = $result->get('start_time')->format('Y-m-d H:i:s')
            . ',' . $result->get('connect_time')->format('Y-m-d H:i:s')
            . ',' . $result->get('end_time')->format('Y-m-d H:i:s');
    $score = number_format($result->get('score'), 2);
    $url = $result->get('url');
    $csv_row = $idstr . ',' . $number . ',' . $country . ',' . $times . ',' . $score . ',' . $url;
    echo "\n" . $csv_row;   // must use double quotes around newline
endforeach;
