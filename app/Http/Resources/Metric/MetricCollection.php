<?php

namespace App\Http\Resources\Metric;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MetricCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Collection
     */
    public function toArray($request)
    {
        return $this->collection;
    }
}
