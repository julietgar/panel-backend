<?php

namespace App\Contracts;

interface Machine
{
     /**
     * Return the current total rows in the metrics table.
     *
     * @return int
     */
    public static function getTotalMetricRows(): int;

    /**
     * Return details about the machine.
     * 
     * @param  string $machineName
     *
     * @return \App\Models\Machine
     */
    public static function getMachineData(string $machineName): \App\Models\Machine;

    /**
     * Return settings about the machine.
     * 
     * @param  string $machineName
     *
     * @return \App\Models\MachineSetting
     */
    public static function getMachineSettings(string $machineName): \App\Models\MachineSetting;

    /**
     * Return psum average value in a percentage representation.
     * 
     * @param  float $psumAvgValue
     * @param  float $psumMaxValue
     *
     * @return float
     */
    public static function getPsumAvgValuePercentage(float $psumAvgValue, float $psumMaxValue): float;

    /**
     * Return the state of a machine.
     * 
     * @param  float $psumAvgValue
     * @param  float $psumMinValue
     * @param  float $psumAvgValuePercentage
     *
     * @return string
     */
    public static function getState(float $psumAvgValue, float $psumMinValue, float $psumAvgValuePercentage): string;

    /**
     * Get last state.
     * 
     * @param  \Illuminate\Database\Eloquent\Collection $metrics
     *
     * @return string
     */
    public static function getLastState(\Illuminate\Database\Eloquent\Collection $metrics): string;

    /**
     * Insert metric machine.
     * 
     * @param  int $machineId
     * @param  string $state
     * @param  float $psumAvgValuePercentage
     * @param  array $metricData
     *
     * @return void
     */
    public static function createMetric(int $machineId, string $state, float $psumAvgValuePercentage, array $metricData): void;

    /**
     * Get the metric data.
     * 
     * @param  string $machineSlug
     * @param  int $quantityRows
     * @param  \Illuminate\Database\Eloquent\Relations\HasMany $metricData
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getMetricData(string $machineSlug, int $quantityRows = 5, \Illuminate\Database\Eloquent\Relations\HasMany $metricData = null): \Illuminate\Database\Eloquent\Collection;
}