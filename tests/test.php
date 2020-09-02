<?php
$ThatTime ="14:08:10";
if (time() >= strtotime($ThatTime)) {
    echo "ok";
}
else echo strtotime($ThatTime);