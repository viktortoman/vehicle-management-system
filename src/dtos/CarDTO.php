<?php

namespace App\VehicleManagementSystem\DTOS;

class CarDTO extends VehicleDTO
{
    /**
     * @var int
     */
    protected int $_numberOfPersons;

    /**
     * @param $id
     * @param $type
     * @param $vehicleType
     * @param $plateNumber
     * @param $placingOnTheMarket
     * @param $createdAt
     * @param $numberOfPersons
     */
    public function __construct(
        $id,
        $type,
        $vehicleType,
        $plateNumber,
        $placingOnTheMarket,
        $createdAt,
        $numberOfPersons
    ) {
        $this->_numberOfPersons = $numberOfPersons;
        parent::__construct($id, $type, $vehicleType, $plateNumber, $placingOnTheMarket, $createdAt);
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return "$this->_type $this->_plateNumber ($this->_numberOfPersons fő)";
    }

    /**
     * @return int
     */
    public function getNumberOfPersons(): int
    {
        return $this->_numberOfPersons;
    }
}