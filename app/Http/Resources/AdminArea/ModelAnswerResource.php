<?php

namespace App\Http\Resources\AdminArea;

use Illuminate\Http\Resources\Json\JsonResource;

class ModelAnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $modelAnswer = $this->resource;

        return [
            'id' => (string) $modelAnswer->getRouteKey(),
            'body' => (string) $modelAnswer->body,
            'question_id' => (string) $modelAnswer->question_id,
            'created_at' => (string) $modelAnswer->created_at,
            'updated_at' => (string) $modelAnswer->updated_at,
        ];
    }
}
