<?php
$day = date('w')-1%7;
$week_start = date('d-m-Y', strtotime('-'.$day.' days'));
$week_end = date('d-m-Y', strtotime('+'.(6-$day).' days'));

echo "start : " . $week_start;
echo "<br>end : " . $week_end;