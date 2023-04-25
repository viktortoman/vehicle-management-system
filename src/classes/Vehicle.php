<?php

namespace App\VehicleManagementSystem\Classes;

use App\VehicleManagementSystem\Interfaces\CrudInterface;
use PDO;

class Vehicle extends Database implements CrudInterface
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
                $result[$key]['type'] = $this->getType($data['type']);
            }
        }

        return $result;
    }
    public function findById($id): false|array
    {
        $sql = "SELECT * FROM vehicles WHERE id = :id";
        $pdoStatement = $this->connection->prepare(
            $sql,
            [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]
        );
        $pdoStatement->execute(['id' => $id]);

        return $pdoStatement->fetch();
    }

    /**
     * @throws \Exception
     */
    public function create($data)
    {
        $sql = "INSERT INTO vehicles (type, plate_number, placing_on_the_market, created_at) VALUES (?,?,?,?)";
        $this->prepare('INSERT', $sql, $data);
    }

    public function update($id, $data)
    {
        $vehicle = $this->findById($id);

        if ($vehicle) {
            $data['id'] = $id;
            $sql = "UPDATE vehicles SET type=?, plate_number=?, placing_on_the_market=?, updated_at=? WHERE id=?";
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

    protected function prepare($type, $sql, $data) {
        $row = [
            $data['type'],
            $data['plate_number'],
            (new \DateTime($data['placing_on_the_market']))->format('Y-m-d'),
            (new \DateTime())->format('Y-m-d H:i:s'),
        ];

        if ($type === 'UPDATE') {
            $row[] = $data['id'];
        }

        $this->connection->prepare($sql)->execute($row);
    }

    protected function getType($type): string
    {
        if ($type === 'car') {
            return 'Car';
        } elseif ($type === 'van') {
            return 'Van';
        } elseif ($type === 'large_truck') {
            return 'Large truck';
        } else {
            return '-';
        }
    }
}