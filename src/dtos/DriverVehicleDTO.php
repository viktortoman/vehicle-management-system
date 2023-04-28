<?php

namespace App\VehicleManagementSystem\DTOS;

class DriverVehicleDTO
{
    /**
     * @var int
     */
    protected int $_id;

    /**
     * @var VehicleDTO
     */
    protected VehicleDTO $_vehicle;

    /**
     * @var DriverDTO
     */
    protected DriverDTO $_driver;

    /**
     * @var string
     */
    protected string $_day;

    /**
     * @var string
     */
    protected string $_createdAt;

    /**
     * @param $id
     * @param $vehicle
     * @param $driver
     * @param $day
     * @param $createdAt
     */
    public function __construct($id, $vehicle, $driver, $day, $createdAt)
    {
        $this->_id = $id;
        $this->_vehicle = $vehicle;
        $this->_driver = $driver;
        $this->_day = $day;
        $this->_createdAt = $createdAt;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->_id;
    }

    /**
     * @return VehicleDTO
     */
    public function getVehicle(): VehicleDTO
    {
        return $this->_vehicle;
    }

    /**
     * @return DriverDTO
     */
    public function getDriver(): DriverDTO
    {
        return $this->_driver;
    }

    /**
     * @return string
     */
    public function getDay(): string
    {
        return $this->_day;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->_createdAt;
    }
}