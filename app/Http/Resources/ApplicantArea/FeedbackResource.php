<?php

namespace App\Http\Resources\ApplicantArea;

use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $feedback = $this->resource;

        return [
            'links' => $feedback['links'],
            'summary' => $feedback['summary'],
        ];
    }
}
