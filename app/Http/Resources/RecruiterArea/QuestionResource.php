<?php

namespace App\Http\Resources\RecruiterArea;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $question = $this->resource;

        return [
            'id' => (string) $question->getRouteKey(),
            'skill_id' => (string) $question->skill_id,
            'body' => (string) $question->body,
            'created_at' => (string) $question->created_at,
            'updated_at' => (string) $question->updated_at,
        ];
    }
}
