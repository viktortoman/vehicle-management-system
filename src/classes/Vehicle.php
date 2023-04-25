<?php

namespace App\VehicleManagementSystem\Classes;

use App\VehicleManagementSystem\Interfaces\CrudInterface;

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
    public function findById($id)
    {
        // TODO: Implement findById() method.
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