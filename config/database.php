<?php

class Database {

    public static function getDatabase() {
        $host = "localhost";
        $port = 3306;
        $username = "root";
        $password = "";
        $dbname = "autentikasi";

        return new \PDO("mysql:host=$host:$port;dbname=$dbname", $username, $password);
    }
}