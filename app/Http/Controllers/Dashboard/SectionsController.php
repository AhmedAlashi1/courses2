<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\CoursesDataTable;
use App\DataTables\SectionsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Courses;
use App\Models\Sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SectionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:display courses', ['only' => ['index']]);
        $this->middleware('permission:create courses', ['only' => ['create','store']]);
        $this->middleware('permission:update courses', ['only' => ['edit','update']]);
        $this->middleware('permission:delete courses', ['only' => ['destroy']]);
    }
    public function index(SectionsDataTable $dataTable , $id){

        return $dataTable->render('dashboard.sections.index',compact('id'));

    }
    public function create($id){

        $sections = Sections::find($id);
        return view('dashboard.sections.create',compact('sections','id'));
    }
    //store
    public function store(Request $request){
        try {
        $sections = Sections::create([
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_ar,
            'status' => '1',
            'courses_id' => $request->courses_id,
        ]);

        toastr()->success(__('messages.Created successfully'));
        return redirect()->route('section.index',$sections->courses_id);
        } catch (\Exception $ex) {
        toastr()->error(__('messages.There was an error try again'));
        return redirect()->route('section.create',$request->courses_id);
        }
    }
    public function edit($id){

        $sections = Sections::find($id);

        return view('dashboard.sections.edit',compact('sections','id'));
    }
    public function update(Request $request,$id)
    {
        $sections = Sections::findorFail($id);
        try {
            $data = $request->all();

            $sections->update($data);

            toastr()->success(__('messages.updated successfully'));
            return redirect()->route('section.index',$sections->courses_id);
        } catch (\Exception $ex) {
            toastr()->error(__('messages.There was an error try again'));
            return redirect()->route('section.edit',$id);
        }
    }

    //destroy

    public function destroy($id){
        $sections = Sections::findorFail($id);
        $sections->delete();
        return response()->json('success');
    }
    public function updateStatus($id)
    {
        try {
            $sections = Sections::findorFail($id);

            $sections->update(['status' => !$sections->status]);
            return response()->json('success');
        } catch (\Exception $ex){
            return response()->json(__('messages.There was an error try again'), 400);
        }
    }



}
