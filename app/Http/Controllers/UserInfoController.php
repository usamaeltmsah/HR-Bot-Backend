<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class UserInfoController extends Controller
{
    public function currentUser(Request $request)
    {
    	$user = $request->user();
    	return new UserResource($user);
    }
}
