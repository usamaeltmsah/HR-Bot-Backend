<?php

namespace App\Http\Resources\RecruiterArea;

use Illuminate\Http\Resources\Json\JsonResource;

class InterviewAnswersReportResource extends JsonResource
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
            'question' => new QuestionResource($answer->question),
            'answer' => new AnswerResource($answer)
        ];
    }
}
