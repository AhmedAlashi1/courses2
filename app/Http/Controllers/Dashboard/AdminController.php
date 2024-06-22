<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\AdminsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{

//    function __construct()
//    {
//        $this->middleware('permission:display admins', ['only' => ['index']]);
//        $this->middleware('permission:create admins', ['only' => ['create','store']]);
//        $this->middleware('permission:update admins', ['only' => ['edit','update']]);
//        $this->middleware('permission:delete admins', ['only' => ['destroy']]);
//    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AdminsDataTable $dataTable)
    {
        return $dataTable->render('dashboard.admins.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('dashboard.admins.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request)
    {
        DB::beginTransaction();
//        try {
            $admin = Admin::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'roles_name' => $request->roles,
                'password' => Hash::make($request->input('password')),
            ]);
            toastr()->success(__('messages.Created successfully'));
            $admin->assignRole($request->input('roles'));
            DB::commit();
            return redirect()->route('admins.index');
//        } catch (\Exception $ex) {
//            DB::rollBack();
//            toastr()->error(__('messages.There was an error try again'));
//            return redirect()->route('admins.create');
//        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $admin = Admin::find($id);
            if (!$admin) {
                toastr()->error( __('messages.The Admin is not exist'));
                return redirect()->route('admins.index');
            }
            $roles = Role::pluck('name','name')->all();
            $userRole = $admin->roles->pluck('name','name')->all();
            return view('dashboard.admins.edit',compact('admin','roles','userRole'));
        }catch (\Exception $ex) {
            toastr()->error(__('messages.There was an error try again'));
            return redirect()->route('admins.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $admin = Admin::find($id); // Retrieve the User model instance

            $admin->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'roles_name' => $request->roles,
            ]);

            if (!empty($request['password'])) {
                $password = Hash::make($request['password']);
                $admin->update([
                    'password' => $password
                ]);
            }
            DB::table('model_has_roles')->where('model_id', $id)->delete();
            $admin->assignRole($request->input('roles'));
            DB::commit();
            toastr()->success( __('messages.updated successfully'));
            return redirect()->route('admins.index');
        } catch (\Exception $ex) {
            DB::rollBack();
            toastr()->error(__('messages.There was an error try again'));
            return redirect()->route('admins.edit', $id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();
        return response()->json('success');
    }
}
