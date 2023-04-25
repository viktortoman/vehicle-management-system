<?php

namespace App\VehicleManagementSystem\Classes;

class Config
{
    public const BASE_URL = 'http://localhost/vehicle-management-system/';
    private string $dbUser = 'root';
    private string $dbPass = '';
    private string $dbHost = 'localhost';
    private string $dbName = 'vehicle-management-system';

    public function getDbUser(): string
    {
        return $this->dbUser;
    }

    public function getDbPass(): string
    {
        return $this->dbPass;
    }

    public function getDbHost(): string
    {
        return $this->dbHost;
    }

    public function getDbName(): string
    {
        return $this->dbName;
    }

    public static function getDatabaseConnectionData(): array
    {
        $config = new Config;

        return [
          'DB_USER' => $config->getDbUser(),
          'DB_PASSWORD' => $config->getDbPass(),
          'DB_HOST' => $config->getDbHost(),
          'DB_NAME' => $config->getDbName(),
        ];
    }
}