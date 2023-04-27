<?php

namespace App\VehicleManagementSystem\DTOS;

class TruckDTO extends VehicleDTO
{
    /**
     * @var int
     */
    protected int $_maximumWeightOfLoad;

    /**
     * @param $id
     * @param $type
     * @param $vehicleType
     * @param $plateNumber
     * @param $placingOnTheMarket
     * @param $createdAt
     * @param $maximumWeightOfLoad
     */
    public function __construct(
        $id,
        $type,
        $vehicleType,
        $plateNumber,
        $placingOnTheMarket,
        $createdAt,
        $maximumWeightOfLoad
    ) {
        $this->_maximumWeightOfLoad = $maximumWeightOfLoad;
        parent::__construct($id, $type, $vehicleType, $plateNumber, $placingOnTheMarket, $createdAt);
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return "$this->_type $this->_plateNumber ($this->_maximumWeightOfLoad Kg)";
    }

    /**
     * @return int
     */
    public function getMaximumWeightOfLoad(): int
    {
        return $this->_maximumWeightOfLoad;
    }
}