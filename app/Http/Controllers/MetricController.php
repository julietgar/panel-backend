<?php

namespace App\Http\Controllers;

use App\Services\Pump;
use App\Http\Resources\Machine\MachineResource;
use App\Http\Requests\MetricRequest;

class MetricController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  MetricRequest  $request
     * @param  string  $machineName
     * @return \Illuminate\Http\Response
     */
    public function show(MetricRequest $request, string $machineSlug)
    {
        return response(new MachineResource(Pump::getMachineData($machineSlug)), 201);
    }
}
