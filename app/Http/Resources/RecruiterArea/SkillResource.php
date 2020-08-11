<?php

namespace App\Http\Resources\RecruiterArea;

use Illuminate\Http\Resources\Json\JsonResource;

class SkillResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $skill = $this->resource;

        return [
            'id'            => $skill->id,
            'name'          => $skill->name,
            'created_at'    => $skill->created_at,
            'updated_at'    => $skill->updated_at
        ];
    }
}
