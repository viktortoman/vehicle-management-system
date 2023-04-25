<?php

namespace App\VehicleManagementSystem\Classes;

use PDO;
use PDOException;

class Database
{
    protected PDO $connection;
    public function __construct()
    {
        $databaseConnectionData = Config::getDatabaseConnectionData();

        try {
            $this->connection = new PDO('mysql:host=' . $databaseConnectionData['DB_HOST'] . ';dbname=' . $databaseConnectionData['DB_NAME'] . ';charset=utf8', $databaseConnectionData['DB_USER'], $databaseConnectionData['DB_PASSWORD']);
        } catch (PDOException $exception) {
            // If there is an error with the connection, stop the script and display the error.
            exit('Failed to connect to database!');
        }

        return $this->connection;
    }
}