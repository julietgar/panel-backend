<?php

namespace App\Http\Resources\Machine;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Metric\MetricCollection;
use App\Services\Pump;

class MachineResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $currentQuantityRows = $request->has('current_quantity_rows') ? $request->input('current_quantity_rows') : 5;
        $metricData = Pump::getMetricData($this->slug, $currentQuantityRows, $this->metrics());
        $lastState = Pump::getLastState($metricData);

        return [
            'machine_name' => $this->name,
            'last_state' => $lastState,
            'metrics' => new MetricCollection($metricData),
        ];
    }
}
