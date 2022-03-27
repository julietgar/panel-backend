<?php

use App\Jobs\PumpProcess;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class MetricTest extends TestCase
{
    public function test_get_metrics_endpoint_response_successful()
    {
        $response = $this->get('api/machines/pump/metric');
        $response->assertStatus(201);
    }

    public function test_run_job()
    {
        Bus::fake();
        PumpProcess::dispatch();
        Bus::assertDispatched(PumpProcess::class);
    }
}