<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\SimpleExcel\SimpleExcelReader;
use App\Models\Metric;
use App\Models\Machine;
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
                $machineData = Pump::getMachineData('pump');
                $machineSettings = Pump::getMachineSettings('pump');

                $metricsAsArray = json_decode($row['metrics'], true);
                $psumAvgValue = $metricsAsArray['Psum']['avgvalue'];
                $psumAvgValuePercentage = Pump::getPsumAvgValuePercentage($psumAvgValue, $machineSettings['psum_max_value']);

                $state = Pump::getState($psumAvgValue, $machineSettings['psum_min_value'], $psumAvgValuePercentage);

                Metric::create([
                    'machine_id' => $machineData->id,
                    'device_id' => $row['deviceid'],
                    'state' => $state,
                    'data' => $row['metrics'],
                    'date_from' => $row['fromts'],
                    'date_to' => $row['tots'],
                    'created_at' => now(),
                ]);
            });
    }
}
