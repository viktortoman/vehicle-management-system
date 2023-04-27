<?php

namespace App\VehicleManagementSystem\DTOS;

class DriverDTO
{
    /**
     * @var int
     */
    protected int $_id;

    /**
     * @var string
     */
    protected string $_name;
    /**
     * @var string
     */
    protected string $_birthDate;
    /**
     * @var string
     */
    protected string $_drivingLicence;
    /**
     * @var string
     */
    protected string $_createdAt;

    /**
     * @param $id
     * @param $name
     * @param $birthDate
     * @param $drivingLicence
     * @param $createdAt
     */
    public function __construct(
        $id,
        $name,
        $birthDate,
        $drivingLicence,
        $createdAt,
    ) {
        $this->_id = $id;
        $this->_name = $name;
        $this->_birthDate = $birthDate;
        $this->_drivingLicence = $drivingLicence;
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
    public function getName(): string
    {
        return $this->_name;
    }

    /**
     * @return string
     */
    public function getBirthDate(): string
    {
        return $this->_birthDate;
    }

    /**
     * @return string
     */
    public function getDrivingLicence(): string
    {
        $drivingLicences = json_decode($this->_drivingLicence);
        $drivingLicence = 'B';

        if (in_array('D', $drivingLicences)) {
            $drivingLicence = 'D';
        } elseif (in_array('C', $drivingLicences)) {
            $drivingLicence = 'C';
        }

        return $drivingLicence;
    }

    public function getVehicleTypesByDrivingLicence(): array
    {
        $vehicleTypes = ['car'];
        $drivingLicences = json_decode($this->_drivingLicence);

        foreach ($drivingLicences as $drivingLicence) {
            if ($drivingLicence === 'D') {
                $vehicleTypes[] = 'large_truck';
            }

            if ($drivingLicence === 'C') {
                $vehicleTypes[] = 'van';
            }
        }

        return $vehicleTypes;
    }
    public function getDrivingLicenceLabel(): string
    {
        return implode(', ', json_decode($this->_drivingLicence));
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->_createdAt;
    }
}