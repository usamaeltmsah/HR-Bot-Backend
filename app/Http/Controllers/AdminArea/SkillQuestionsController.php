<?php

namespace App\Http\Controllers\AdminArea;

use App\Skill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdminArea\QuestionResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SkillQuestionsController extends Controller
{
    public function index(Skill $skill): ResourceCollection
    {
    	$questions = $skill->questions()->paginate();

    	return QuestionResource::collection($questions);
    }
}
