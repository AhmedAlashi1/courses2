<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CoursesResource;
use App\Http\Resources\MealsResource;
use App\Http\Resources\SectionsResource;
use App\Models\BuyCourseUser;
use App\Models\Courses;
use Illuminate\Http\Request;

class CoursesController extends Controller
{

    public function index(Request $request){

        $courss = Courses::query();
         $courss->where('status', 1);
         //key
        $courss->when('key', function ($query) use ($request){
            $query->where('title_ar', 'like', '%' . $request->key . '%');
            $query->whereOr('title_en', 'like', '%' . $request->key . '%');
        });
        $data = $courss->get();

        return sendResponse(CoursesResource::collection($data));
    }
    public function show($id){


        $data = Courses::where('id', $id)
            ->with(['section' => function ($query) {
                $query->where('status', 1);
                $query->with('videos',function ($q){
                    $q->where('status', '1');
                });
            }, 'section.videos'])
            ->first();
//        return $data;

        if (!$data) {
            return sendError('course not found');
        }
        return sendResponse(new CoursesResource($data));
    }
}
