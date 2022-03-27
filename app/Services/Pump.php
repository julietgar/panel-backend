<?php

namespace App\Services;

use App\Models\Metric;
use App\Models\Machine;
use App\Models\MachineSetting;
use App\Contracts\Machine as MachineContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pump implements MachineContract
{
    public static function getTotalMetricRows(): int
    {
        return Metric::count();
    }

    public static function getMachineData(string $machineSlug): Machine
    {
        return Machine::where('slug', $machineSlug)->first();
    }

    public static function getMachineSettings(string $machineSlug): MachineSetting
    {
        return self::getMachineData($machineSlug)->setting()->first();
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
        if($psumAvgValue == 0.0) {
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

    public static function getLastState(Collection $metrics): string|null
    {
        return $metrics->first()['state'] ?? null;
    }

    public static function createMetric(int $machineId, string $state, float $psumAvgValuePercentage, array $metricData): void
    {
        Metric::create([
            'machine_id' => $machineId,
            'device_id' => $metricData['deviceid'],
            'state' => $state,
            'psum_avg_percentage' => $psumAvgValuePercentage,
            'data' => $metricData['metrics'],
            'date_from' => $metricData['fromts'],
            'date_to' => $metricData['tots'],
            'created_at' => now(),
        ]);
    }

    public static function getMetricData(string $machineSlug, int $quantityRows = 5, HasMany $metricData = null): Collection
    {
        if(is_null($metricData)) {
            return self::getMachineData($machineSlug)
            ->metrics()
            ->orderBy('date_from', 'desc')
            ->take($quantityRows)
            ->get();
        }
    
        return $metricData
            ->orderBy('date_from', 'desc')
            ->take($quantityRows)
            ->get();
    }
}