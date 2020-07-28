<?php

namespace App\Http\Controllers;

use App\Skill;
use App\Http\Requests\SkillFormRequest;
use App\Http\Resources\SkillResource;

class SkillsController extends Controller{

    public function index(){
        $skills = Skill::orderBy('id', 'desc')->paginate();
        return SkillResource::collection($skills);
    }

    public function show(Skill $skill){
        return new SkillResource($skill);
    }

    public function store(SkillFormRequest $request){

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

//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  \App\Skill  $skill
//     * @return \Illuminate\Http\Response
//     */
//    public function destroy(Skill $skill)
//    {
//        $skill->delete();

// //        $response = [
// //            'msg' => 'Skill'.$skill.'successfully deleted',
// //        ];
// //        return response()->json($response, 204);
//        return response()->json();
//    }
}
