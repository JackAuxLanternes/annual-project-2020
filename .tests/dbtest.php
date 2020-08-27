<title>DBTest</title>
<?php
require_once __DIR__ . '/../utils/database/databasemanager.php';
//include('../api/includes/config.php');

$database = new DatabaseManager();
echo "test";

$req = $database->find("SELECT * FROM user WHERE email=?", ['qrouville@gmail.com']);

echo $req['first_name'];

echo "ok";
