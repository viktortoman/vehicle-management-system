<?php

namespace App\VehicleManagementSystem\Classes;

use App\VehicleManagementSystem\Interfaces\CrudInterface;
use PDO;

class Driver extends Database implements CrudInterface
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

        return $pdoStatement->fetchAll();
    }
    public function findById($id): false|array
    {
        $sql = "SELECT * FROM drivers WHERE id = :id";
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
        $sql = "INSERT INTO drivers (name, birth_date, created_at) VALUES (?,?,?)";
        $this->prepare('INSERT', $sql, $data);
    }

    public function update($id, $data)
    {
        $vehicle = $this->findById($id);

        if ($vehicle) {
            $data['id'] = $id;
            $sql = "UPDATE drivers SET name=?, birth_date=?, updated_at=? WHERE id=?";
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

    protected function prepare($type, $sql, $data) {
        $row = [
            $data['name'],
            $data['birth_date'],
            (new \DateTime())->format('Y-m-d H:i:s'),
        ];

        if ($type === 'UPDATE') {
            $row[] = $data['id'];
        }

        $this->connection->prepare($sql)->execute($row);
    }
}