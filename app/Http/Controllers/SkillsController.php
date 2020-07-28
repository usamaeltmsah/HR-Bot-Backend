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

//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @return SkillResource
//     */
//    public function store(Request $request):SkillResource
//    {
//        $request->validate([
//           'name' => 'required',
//        ]);
//
//        $skill =Skill::create($request->all());
//        return new SkillResource($skill);
//    }

//    /**
//     * Display the specified resource.
//     *
//     * @param  \App\Skill $skill
//     * @return SkillResource|\Illuminate\Http\Response
//     */
//    public function show(Skill $skill):SkillResource
//    {
//        return new SkillResource(Skill::firstWhere('id', $skill->id));
//    }

//    /**
//     * Update the specified resource in storage.
//     *
//     * @param  \Illuminate\Http\Request $request
//     * @param  \App\Skill $skill
//     * @return SkillResource|\Illuminate\Http\Response
//     */
//    public function update(Request $request, Skill $skill): SkillResource
//    {
//        $skill->update($request->all());
//
//        return new SkillResource($skill);
//    }

//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  \App\Skill  $skill
//     * @return \Illuminate\Http\Response
//     */
//    public function destroy(Skill $skill)
//    {
//        $skill->delete();
//
////        $response = [
////            'msg' => 'Skill'.$skill.'successfully deleted',
////        ];
////        return response()->json($response, 204);
//        return response()->json();
//    }
}
