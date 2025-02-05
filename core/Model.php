<?php

namespace Core;

use PDO;
use PDOException;

class Model
{
    protected $table;

    function __construct($table)
    {
        $this->table = $table;
    }

    protected function connectDB()
    {
        try {
            $host = config('db_host');
            $dbname = config('db_name');
            $username = config('db_user');
            $password = config('db_password');

            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $pdo;
        } catch (PDOException $exception) {
            die("Connection failed: " . $exception->getMessage());
        }
    }
}