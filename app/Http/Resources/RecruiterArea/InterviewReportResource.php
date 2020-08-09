<?php

namespace App\Http\Resources\RecruiterArea;

use Illuminate\Http\Resources\Json\JsonResource;

class InterviewReportResource extends JsonResource
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
            'score' => (string) $interview->score,
            'status' => (string) $interview->status,
            'submitted_at' => (string) $interview->submitted_at,
            'created_at' => (string) $interview->created_at,
            'updated_at' => (string) $interview->updated_at,
            'job' => new JobResource($interview->job),
            'applicant' => new ApplicantResource($interview->applicant),
            'report' => InterviewAnswersReportResource::collection($interview->answers),
        ];
    }
}
