<?php

namespace App\VehicleManagementSystem\Classes;

use App\VehicleManagementSystem\DTOS\DriverDTO;
use App\VehicleManagementSystem\DTOS\DriverVehicleDTO;
use App\VehicleManagementSystem\DTOS\VehicleDTO;
use App\VehicleManagementSystem\Interfaces\CrudInterface;
use PDO;

class DriverVehicle extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM driver_vehicles ORDER BY id DESC";
        $pdoStatement = $this->connection->prepare($sql);
        $result = $pdoStatement->fetchAll();

        if ($result) {
            foreach ($result as $key => $data) {
                $result[$key] = $this->makeDTO($data);
            }
        }

        return $result;
    }

    public function getAllByDriverId($driverId): array
    {
        $sql = "SELECT * FROM driver_vehicles AS dv INNER JOIN drivers AS d ON dv.driver_id = d.id INNER JOIN vehicles AS v ON dv.vehicle_id = v.id WHERE dv.driver_id = :driverId";
        $pdoStatement = $this->connection->prepare($sql);
        $pdoStatement->execute(['driverId' => $driverId]);

        $result = $pdoStatement->fetchAll();

        if ($result) {
            foreach ($result as $key => $data) {
                $result[$key] = $this->makeDTO($data);
            }
        }

        return $result;
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

    protected function makeDTO($data): DriverVehicleDTO
    {
        $vehicle = Vehicle::makeDTO($data);
        $driver = Driver::makeDTO($data);

        return new DriverVehicleDTO(
            $data['id'], $vehicle, $driver, $data['day'], $data['created_at']
        );
    }
}