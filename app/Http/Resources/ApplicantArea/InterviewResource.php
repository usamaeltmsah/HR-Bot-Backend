<?php

namespace App\Http\Resources\ApplicantArea;

use Illuminate\Http\Resources\Json\JsonResource;

class InterviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $interview = $request->resource;

        return [
            'id' => (string) $interview->getRouteKey(),
            'job_id' => (string) $interview->job_id,
            'submitted_at' => (string) $interview->submitted_at,
        ];
    }
}
