<?php

namespace App\VehicleManagementSystem\DTOS;

class VehicleDTO
{
    /**
     * @var int
     */
    protected int $_id;

    /**
     * @var string
     */
    protected string $_type;
    /**
     * @var string
     */
    protected string $_vehicleType;

    /**
     * @var string
     */
    protected string $_plateNumber;
    /**
     * @var string
     */
    protected string $_placingOnTheMarket;
    /**
     * @var string
     */
    protected string $_createdAt;

    /**
     * @param $id
     * @param $type
     * @param $vehicleType
     * @param $plateNumber
     * @param $placingOnTheMarket
     * @param $createdAt
     */
    public function __construct(
        $id,
        $type,
        $vehicleType,
        $plateNumber,
        $placingOnTheMarket,
        $createdAt,
    ) {
       $this->_id = $id;
       $this->_type = $type;
       $this->_vehicleType = $vehicleType;
       $this->_plateNumber = $plateNumber;
       $this->_placingOnTheMarket = $placingOnTheMarket;
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
     * @return string
     */
    public function getType(): string
    {
        return $this->_type;
    }

    /**
     * @return string
     */
    public function getVehicleType(): string
    {
        return $this->_vehicleType;
    }

    /**
     * @return string
     */
    public function getPlateNumber(): string
    {
        return $this->_plateNumber;
    }

    /**
     * @return string
     */
    public function getPlacingOnTheMarket(): string
    {
        return $this->_placingOnTheMarket;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->_createdAt;
    }

    public function getVehicleTypeLabel(): string
    {
        if ($this->getVehicleType() === 'car') {
            return 'Car';
        } elseif ($this->getVehicleType() === 'van') {
            return 'Van';
        } else {
            return 'Large truck';
        }
    }

}