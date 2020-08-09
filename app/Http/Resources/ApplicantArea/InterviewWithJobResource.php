<?php

namespace App\Http\Resources\ApplicantArea;

use Illuminate\Http\Resources\Json\JsonResource;

class InterviewWithJobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $interview = $this->resource;

        return [
            'id' => (string) $interview->getRouteKey(),
            'job' => new JobResource($interview->job),
            'status' => (string) $interview->status,
            'feedback' => (string) $interview->feedback,
            'submitted_at' => (string) $interview->submitted_at,
            'created_at' => (string) $interview->created_at,
            'updated_at' => (string) $interview->updated_at,
        ];
    }
}
