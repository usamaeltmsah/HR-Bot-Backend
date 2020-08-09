<?php

namespace App\Http\Resources\ApplicantArea;

use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $job = $this->resource;

        return [
            'id' => (string) $job->getRouteKey(),
            'title' => (string) $job->title,
            'description' => (string) $job->description,
            'accept_interviews_from' => (string) $job->accept_interviews_from,
            'accept_interviews_until' => (string) $job->accept_interviews_until,
            'interviews_duration' => (string) $job->interviews_duration,
            'recruiter_id' => (string) $job->recruiter_id,
        ];
    }
}
