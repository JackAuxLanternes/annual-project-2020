<?php

require_once "databasemanager.php";

abstract class form
{
    public DatabaseManager $db;

    public function __construct()
    {
        $this->db = new DatabaseManager();
    }


}