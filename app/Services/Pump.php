<?php

namespace App\Services;

use App\Models\Metric;
use App\Models\Machine;
use App\Models\MachineSetting;
use App\Contracts\Machine as MachineContract;

class Pump implements MachineContract
{
    public static function getTotalMetricRows(): int
    {
        return Metric::count();
    }

    public static function getMachineData(string $machineName): Machine
    {
        return Machine::where('slug', $machineName)->first();
    }

    public static function getMachineSettings(string $machineName): MachineSetting
    {
        return self::getMachineData($machineName)->setting()->first();
    }

    public static function getPsumAvgValuePercentage(float $psumAvgValue, float $psumMaxValue): float
    {
        return round((100 * $psumAvgValue) / $psumMaxValue, 2);
    }

    public static function getState(float $psumAvgValue, float $psumMinValue, float $psumAvgValuePercentage): string
    {
        // is 20-100+% of operating load
        $state = "On - loaded";

        // is power off, no data
        if($psumAvgValue === 0) {
            $state = "Off";
        }
        // is power on, no current
        else if($psumAvgValue < $psumMinValue) {
            $state = "On - unloaded";
        }
        // is less than 20% of operating load
        else if($psumAvgValuePercentage < 20) {
            $state = "On - idle";
        }

        return $state;
    }
}