<?php

namespace App\VehicleManagementSystem\Classes;

use App\VehicleManagementSystem\DTOS\DriverDTO;
use App\VehicleManagementSystem\Interfaces\DriverInterface;
use PDO;

class Driver extends Database implements DriverInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll(): false|array
    {
        $sql = "SELECT * FROM drivers WHERE deleted_at IS NULL ORDER BY id DESC";
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
    public function findById($id): ?DriverDTO
    {
        $sql = "SELECT * FROM drivers WHERE id = :id";
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
        $sql = "INSERT INTO drivers (name, birth_date, driving_licences, created_at) VALUES (?,?,?,?)";
        $this->prepare('INSERT', $sql, $data);
    }

    public function update($id, $data)
    {
        $vehicle = $this->findById($id);

        if ($vehicle) {
            $data['id'] = $id;
            $sql = "UPDATE drivers SET name=?, birth_date=?, driving_licences=? updated_at=? WHERE id=?";
            $this->prepare('UPDATE', $sql, $data);
        }
    }

    public function delete($id, $type = 'SOFT')
    {
        if ($type === 'HARD') {
            $sql = "DELETE FROM drivers WHERE id = :id";
            $pdoStatement = $this->connection->prepare($sql);
            $pdoStatement->execute(['id' => $id]);
        } else {
            $sql = "UPDATE drivers SET deleted_at=? WHERE id=?";
            $this->connection->prepare($sql)->execute([
                (new \DateTime())->format('Y-m-d H:i:s'),
                $id
            ]);
        }
    }

    /**
     * @throws \Exception
     */
    public function assignVehicle($data)
    {
        $driverVehicle = new DriverVehicle();
        $driverVehicle->create($data);
    }

    protected function prepare($type, $sql, $data) {
        $drivingLicences = ['B'];

        if ($data['driving_licence'] === 'C') {
            $drivingLicences[] = 'C';
        } elseif($data['driving_licence'] === 'D') {
            $drivingLicences[] = 'C';
            $drivingLicences[] = 'D';
        }

        $row = [
            $data['name'],
            $data['birth_date'],
            json_encode($drivingLicences),
            (new \DateTime())->format('Y-m-d H:i:s'),
        ];

        if ($type === 'UPDATE') {
            $row[] = $data['id'];
        }

        $this->connection->prepare($sql)->execute($row);
    }

    protected function makeDTO($data): DriverDTO
    {
        return new DriverDTO(
            $data['id'],
            $data['name'],
            $data['birth_date'],
            $data['driving_licences'],
            $data['created_at'],
        );
    }
}