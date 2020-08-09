<?php

namespace App\Http\Controllers\AdminArea;

use App\Skill;
use Illuminate\Http\Response;
use App\Http\Resources\AdminArea\SkillResource;
use App\Http\Requests\AdminArea\SkillFormRequest;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SkillsController extends Controller {

    /**
     * Get all the skills
     * 
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function index(): ResourceCollection 
    {
        $skills = Skill::latest()->paginate();

        return SkillResource::collection($skills);
    }

    /**
     * Get the skill with the given id
     * 
     * @param  \App\Skill $skill
     * @return \App\Http\Resources\SkillResource
     */
    public function show(Skill $skill): SkillResource 
    {
        return new SkillResource($skill);
    }

    /**
     * Store a new skill with the given data
     * 
     * @param  \App\Http\Requests\SkillFormRequest $request
     * 
     * @return \App\Http\Resources\SkillResource
     */
    public function store(SkillFormRequest $request): SkillResource 
    {
        $skill = Skill::create($request->validated());

        return new SkillResource($skill);
    }

   /**
    * Update the specified skill in storage.
    *
    * @param  \App\Http\Requests\SkillFormRequest $request
    * @param  \App\Skill $skill
    * @return \App\Http\Resources\SkillResource
    */
   public function update(SkillFormRequest $request, Skill $skill): SkillResource 
   {
       $skill->update($request->validated());

       return new SkillResource($skill);
   }

   /**
    * Remove the specified skill from storage.
    *
    * @param  \App\Skill  $skill
    * @return \Illuminate\Http\Response
    */
   public function destroy(Skill $skill): Response 
   {
       $skill->delete();
       
       return response(null, 204);
   }
}
