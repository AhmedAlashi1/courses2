<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Models\Courses;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\UserExerciseDays;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class UserController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:display users', ['only' => ['index']]);
        $this->middleware('permission:delete users', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UsersDataTable $dataTable)
    {

        return $dataTable->render('dashboard.users.index');


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('dashboard.users.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        return $request->all();

        try {
            $request['phone']= '00965'.$request->phone;

            $validator = Validator::make($request->all(), [
                'phone' => 'required|unique:users,phone|numeric',
            ]);
            if ($validator->fails()) {
                $input = $request->all();
                $input['phone'] = Str::after($input['phone'], '00965');
                return redirect()->route('users.create')
                    ->withErrors($validator)
                    ->withInput($input);
            }
            //error validate


            $user = User::create([
            'name' => $request->name ?$request->name : $request->phone,
            'phone' => $request->phone,
            'password' => Hash::make($request->phone),
             'status' => 'inactive',
        ]);
        toastr()->success(__('messages.Created successfully'));
        return redirect()->route('users.index');
            } catch (\Exception $ex) {
        toastr()->error(__('messages.There was an error try again'));
        return redirect()->route('users.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                toastr()->error( __('messages.The Admin is not exist'));
                return redirect()->route('users.index');
            }
            $user_details = UserDetails::where('user_id',$id)->first();
            $user_exercise_days = UserExerciseDays::selectRaw('SUM(IF(is_done=1,1,0)) as done,SUM(IF(is_done=0,1,0)) as not_done')
                ->where([
                    'user_id' => $id,
                    'status' => 1
                ])
                ->first();

            $current_exercise = [];
            $userExercise = UserExerciseDays::where(['user_id' => $id, 'date' => now()->format('Y-m-d')])->first();
            if ($userExercise) {
                $exerciseDays = UserExerciseDays::where(['user_id' => $id, 'week' => $userExercise->week])->get()->toArray();
                $day = key( Arr::where($exerciseDays, fn($row) => $row['id'] == $userExercise->id)) + 1;
                $current_exercise = [
                    'week' => $userExercise->week,
                    'day' => $day
                ];
            }
            return view('dashboard.users.show',compact('user','user_details','user_exercise_days', 'current_exercise'));
        }catch (\Exception $ex) {
            toastr()->error(__('messages.There was an error try again'));
            return redirect()->route('users.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json('success');
    }

    public function updateStatus(User $user)
    {
        try {
            $status = $user->status === 'active' ? 'inactive' : 'active';
            $user->update(['status' => $status]);
            return response()->json('success');
        } catch (\Exception $ex){
            return response()->json(__('messages.There was an error try again'), 400);
        }
    }
}
