<?php

namespace App\Http\Resources\RecruiterArea;

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
            'score' => (string) $answer->score,
            'question_id' => (string) $answer->question_id,
            'interview_id' => (string) $answer->interview_id,
            'created_at' => (string) $answer->created_at,
            'updated_at' => (string) $answer->updated_at,
        ];
    }
}
