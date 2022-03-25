<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\SimpleExcel\SimpleExcelReader;
use App\Services\Pump;

class PumpProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $pathToCsv = storage_path('app/public/demoPumpDayDataOff.csv');

        SimpleExcelReader::create($pathToCsv)->getRows()
            ->sortBy('fromts') // Sort Asc
            ->skip(Pump::getTotalMetricRows()) // skip the total quantity rows that we already have in the table
            ->take(1) // take the last row that has not been processed
            ->each(function(array $row) {
                $machineSettings = Pump::getMachineSettings('pump');
                $metricsAsArray = json_decode($row['metrics'], true);
                $psumAvgValuePercentage = Pump::getPsumAvgValuePercentage($metricsAsArray['Psum']['avgvalue'], $machineSettings['psum_max_value']);

                Pump::createMetric(
                    Pump::getMachineData('pump')->id, 
                    Pump::getState($metricsAsArray['Psum']['avgvalue'], $machineSettings['psum_min_value'], $psumAvgValuePercentage),
                    $psumAvgValuePercentage,
                    $row
                );
            });
    }
}
