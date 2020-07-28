<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use App\Http\Requests\SkillFormRequest;
use App\Http\Resources\SkillResource;
use App\Skill;
use Illuminate\Http\Request;
use Validator;

class SkillsController extends BackEndController{

    public function __construct(Skill $model)
    {
        parent::__construct($model);
    }

    /**
     * @overwrite to
     * construct the json response for index method
     */
    protected function responsePartialContent($rows){

        return SkillResource::collection($rows);
    }


    public function show(Skill $skill){
        return new SkillResource($skill);
    }

    /** validation on the request to store a new skill */
    protected function storeValidator(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string']
        ]);
        return $validator;
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
