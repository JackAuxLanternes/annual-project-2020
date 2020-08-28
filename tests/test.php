<?php
$dir    = __DIR__;
$files1 = scandir($dir);
$files2 = scandir($dir, 1);

foreach ($files1 as $item) {
    if(strpos($item, '')) echo "<br>" . $item;
}