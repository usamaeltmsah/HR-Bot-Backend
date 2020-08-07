<?php

namespace App\Http\Resources\ApplicantArea;

use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $answer = $this->resource;

        return [
            'id' => (string) $answer->getRouteKey(),
            'body' => (string) $answer->body,
        ];
    }
}
