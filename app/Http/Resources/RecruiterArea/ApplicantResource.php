<?php

namespace App\Http\Resources\RecruiterArea;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $applicant = $this->resource;

        return [
            'id' => (string) $applicant->getRouteKey(),
            'name' => (string) $applicant->name,
            'email' => (string) $applicant->email,
        ];
    }
}
