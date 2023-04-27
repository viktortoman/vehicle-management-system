<?php

namespace App\VehicleManagementSystem\Interfaces;

interface DriverInterface extends CrudInterface
{
    public function assignVehicle($data);
}