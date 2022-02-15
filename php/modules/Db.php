<?php

class Db {
    private $dbh;

    function __construct ($db) {
        $this->dbh = new PDO($db->type . ':host=' . $db->host . ';dbname=' . $db->name, $db->user, $db->password);
    }
}