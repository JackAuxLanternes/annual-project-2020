<?php

require_once ('../utils/database/databasemanager.php');
$database = new DatabaseManager();

$servicedata = $database->find("SELECT * FROM service WHERE id=?", ['06e085b3-ed29-4efa-8699-a7012c5908d3']);

if($servicedata != null){

    switch ($servicedata['flow_frequency_shape']){?><?php
        case 'hours':
            ?>checkedh<?php
            break;
        case 'day':
            ?>checkedd<?php
            break;
        default:
            echo 'checked';
            echo 'value="' . $servicedata['flow_frequency_shape'] . '"';
    }
}
else echo "Rat thé";