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
        $pdoStatement = $this->connection->prepare("SELECT * FROM vehicles ORDER BY id DESC");
        $pdoStatement->execute();

        return $pdoStatement->fetchAll();
    }
    public function findById($id): false|array
    {
        $pdoStatement = $this->connection->prepare(
            "SELECT * FROM vehicles WHERE id = :id",
            [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]
        );
        $pdoStatement->execute(['id' => $id]);

        return $pdoStatement->fetchAll();
    }

    public function create($data)
    {
        // TODO: Implement create() method.
    }

    public function update($id, $data)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }
}