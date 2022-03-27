<?php
 
namespace App\Http\Resources\Metric;
 
use Illuminate\Http\Resources\Json\JsonResource;
 
class MetricResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $epochMilisecondsToSeconds = $this->date_from / 1000;
        $epochDateTime = new \DateTime("@$epochMilisecondsToSeconds");

        return [
            'datetime_created' => $epochDateTime->format('m-d-Y H:i:s'),
            'psum_avg_value' => round(json_decode($this->data)->Psum->avgvalue, 3),
            'operating_load_percentage' => $this->psum_avg_percentage."%",
            'state' => $this->state,
        ];
    }
}