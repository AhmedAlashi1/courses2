<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\CoursesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CoursesRequest;
use App\Models\Courses;
//use App\Traits\ImageTrait;
use App\Models\User;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Rap2hpoutre\FastExcel\FastExcel;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\App;

class CoursesController extends Controller
{
    use ImageTrait;
    public function __construct()
    {
        $this->middleware('permission:display courses', ['only' => ['index']]);
        $this->middleware('permission:create courses', ['only' => ['create','store']]);
        $this->middleware('permission:update courses', ['only' => ['edit','update']]);
        $this->middleware('permission:delete courses', ['only' => ['destroy']]);
    }

//    use ImageTrait;


    public function index(CoursesDataTable $dataTable)
    {
        return $dataTable->render('dashboard.courses.index');
    }

    public function create()
    {
        return view('dashboard.courses.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $image_path = '';
    try {
        if ($request->has('photo')) {
            $image_path = $this->uploadImage('admin', $request->photo);
        }
        $courses = Courses::create([
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
            'status' => '1',
            'image' => $image_path,
            'is_paid' => $request->is_paid,
        ]);

        toastr()->success(__('messages.Created successfully'));
        return redirect()->route('courses.index');
    } catch (\Exception $ex) {
        toastr()->error(__('messages.There was an error try again'));
        return redirect()->route('courses.create');
    }
}

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     */
    public function edit($id)
    {
        $courses=Courses::findorFail($id);

        return view('dashboard.courses.edit', compact('courses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CoursesRequest $request
     * @param Courses $courses
     */
    public function update(Request $request,$id)
    {
//        return $request;
        $courses = Courses::findorFail($id);
        try {
            $data = $request->all();

            if ($request->has('photo')) {
                $image_path = $this->uploadImage('admin', $request->photo);
                $data['image'] = $image_path;
                if ($courses->image && File::exists($courses->image)) {
                    File::delete($courses->image);
                }
            }


            $courses->update($data);

            toastr()->success(__('messages.updated successfully'));
            return redirect()->route('courses.index');
        } catch (\Exception $ex) {
            toastr()->error(__('messages.There was an error try again'));
            return redirect()->route('courses.edit');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Courses $courses
     */
    public function destroy($courses)
    {
        $courses = Courses::findorFail($courses);
        if ($courses->image && File::exists($courses->image)) {
            File::delete($courses->image);
        }
        $courses->delete();
        return response()->json('success');
    }

    public function updateStatus($id)
    {
       try {
            $courses = Courses::findorFail($id);

           $courses->update(['status' => !$courses->status]);
            return response()->json('success');
       } catch (\Exception $ex){
           return response()->json(__('messages.There was an error try again'), 400);
       }
    }
    public function FastExcel(){

        return (new FastExcel($this->usersGenerator()))->export('test.xlsx');
    }

    function usersGenerator() {
        $users = User::limit(1)->cursor();
        foreach ($users as $user) {
            yield $user;
        }
    }
}
