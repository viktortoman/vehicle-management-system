<?php

namespace App\VehicleManagementSystem\Classes;

use App\VehicleManagementSystem\DTOS\CarDTO;
use App\VehicleManagementSystem\DTOS\TruckDTO;
use App\VehicleManagementSystem\DTOS\VehicleDTO;
use App\VehicleManagementSystem\Interfaces\VehicleInterface;
use PDO;

class Vehicle extends Database implements VehicleInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll(): false|array
    {
        $sql = "SELECT * FROM vehicles WHERE deleted_at IS NULL ORDER BY id DESC";
        $pdoStatement = $this->connection->prepare($sql);
        $pdoStatement->execute();

        $result = $pdoStatement->fetchAll();

        if ($result) {
            foreach ($result as $key => $data) {
                $result[$key] = $this->makeDTO($data);
            }
        }

        return $result;
    }

    public function getAllByVehicleTypes($vehicleTypes): false|array
    {
        $sql = 'SELECT * FROM vehicles WHERE deleted_at IS NULL AND `vehicle_type` in('.trim(str_repeat(', ?', count($vehicleTypes)), ', ').')';

        $pdoStatement = $this->connection->prepare($sql);
        $pdoStatement->execute($vehicleTypes);

        $result = $pdoStatement->fetchAll();

        if ($result) {
            foreach ($result as $key => $data) {
                $result[$key] = $this->makeDTO($data);
            }
        }

        return $result;
    }

    public function findById($id): VehicleDTO|CarDTO|TruckDTO|null
    {
        $sql = "SELECT * FROM vehicles WHERE id = :id";
        $pdoStatement = $this->connection->prepare(
            $sql,
            [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]
        );
        $pdoStatement->execute(['id' => $id]);
        $data = $pdoStatement->fetch();

        if ($data) {
            return $this->makeDTO($data);
        }

        return null;
    }

    /**
     * @throws \Exception
     */
    public function create($data)
    {
        $sql = "INSERT INTO vehicles (
                      type, 
                      vehicle_type, 
                      plate_number, 
                      placing_on_the_market, 
                      created_at, 
                      number_of_persons, 
                      maximum_weight_of_load
                      ) VALUES (?,?,?,?,?,?,?)";
        $this->prepare('INSERT', $sql, $data);
    }

    public function update($id, $data)
    {
        $vehicle = $this->findById($id);

        if ($vehicle) {
            $data['id'] = $id;
            $sql = "UPDATE vehicles SET 
                    type=?, 
                    vehicle_type=? 
                    plate_number=?, 
                    placing_on_the_market=?, 
                    updated_at=?, 
                    number_of_persons=?, 
                    maximum_weight_of_load=? WHERE id=?";
            $this->prepare('UPDATE', $sql, $data);
        }
    }

    public function delete($id, $type = 'SOFT')
    {
        if ($type === 'HARD') {
            $sql = "DELETE FROM vehicles WHERE id = :id";
            $pdoStatement = $this->connection->prepare($sql);
            $pdoStatement->execute(['id' => $id]);
        } else {
            $sql = "UPDATE vehicles SET deleted_at=? WHERE id=?";
            $this->connection->prepare($sql)->execute([
                (new \DateTime())->format('Y-m-d H:i:s'),
                $id
            ]);
        }
    }

    protected function prepare($type, $sql, $data)
    {
        $row = [
            $data['type'],
            $data['vehicle_type'],
            $data['plate_number'],
            (new \DateTime($data['placing_on_the_market']))->format('Y-m-d'),
            (new \DateTime())->format('Y-m-d H:i:s'),
            $data['number_of_persons'] ?: null,
            $data['maximum_weight_of_load'] ?: null
        ];

        if ($type === 'UPDATE') {
            $row[] = $data['id'];
        }

        $this->connection->prepare($sql)->execute($row);
    }

    public static function makeDTO($data): VehicleDTO
    {
        if ($data['vehicle_type'] === 'car') {
            return new CarDTO(
                $data['id'],
                $data['type'],
                $data['vehicle_type'],
                $data['plate_number'],
                $data['placing_on_the_market'],
                $data['created_at'],
                $data['number_of_persons']
            );
        } else {
            return new TruckDTO(
                $data['id'],
                $data['type'],
                $data['vehicle_type'],
                $data['plate_number'],
                $data['placing_on_the_market'],
                $data['created_at'],
                $data['maximum_weight_of_load']
            );
        }
    }
}