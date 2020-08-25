<?php

//  TODO: NEED TO BE CHANGED BY WHERE YOU PUT THIS PROJET FILES
$currentdirectory = "/htdocs/2ème année/Projet Annuel (Rattrapage)/Website";

require_once __DIR__ . "/../../utils/database/databasemanager.php";
$database = new DatabaseManager();

session_start();
$connected = isset($_SESSION['user']);