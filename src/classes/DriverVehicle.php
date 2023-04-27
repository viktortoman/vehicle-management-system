<?php

namespace App\VehicleManagementSystem\Classes;

use App\VehicleManagementSystem\Interfaces\CrudInterface;
use PDO;

class DriverVehicle extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll(): false|array
    {
        $sql = "SELECT * FROM driver_vehicles ORDER BY id DESC";
        $pdoStatement = $this->connection->prepare($sql);
        $pdoStatement->execute();

        return $pdoStatement->fetchAll();
    }

    /**
     * @throws \Exception
     */
    public function create($data)
    {
        $sql = "INSERT INTO driver_vehicles (driver_id, vehicle_id, day) VALUES (?,?,?)";
        $this->prepare('INSERT', $sql, $data);
    }

    protected function prepare($type, $sql, $data) {
        $row = [
            $data['driver_id'],
            $data['vehicle_id'],
            (new \DateTime($data['day']))->format('Y-m-d H:i:s'),
        ];

        if ($type === 'UPDATE') {
            $row[] = $data['id'];
        }

        $this->connection->prepare($sql)->execute($row);
    }
}