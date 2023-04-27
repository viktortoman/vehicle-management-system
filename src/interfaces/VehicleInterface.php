<?php

namespace App\VehicleManagementSystem\Interfaces;

interface VehicleInterface extends CrudInterface
{
    public function getAllByVehicleTypes($vehicleTypes);
}