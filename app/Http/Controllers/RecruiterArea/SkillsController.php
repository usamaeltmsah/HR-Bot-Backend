<?php

namespace App\Http\Controllers\RecruiterArea;

use App\Skill;
use App\Http\Controllers\Controller;
use App\Http\Resources\RecruiterArea\SkillResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SkillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $skills = Skill::latest()->paginate();

        return SkillResource::collection($skills);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Skill  $skill
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(Skill $skill)
    {
        return new SkillResource($skill);
    }
}
