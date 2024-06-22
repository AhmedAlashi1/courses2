<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

//    function __construct()
//    {
//        $this->middleware('permission:display roles', ['only' => ['index']]);
//        $this->middleware('permission:create roles', ['only' => ['create','store']]);
//        $this->middleware('permission:update roles', ['only' => ['edit','update']]);
//        $this->middleware('permission:delete roles', ['only' => ['destroy']]);
//    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::orderBy('id','DESC')->get();
//        return $roles;
        return view('dashboard.roles.index', compact('roles'))->render();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = $this->groupedPermissions();
        return view('dashboard.roles.create',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $role = Role::create(['name' => $request->input('name')]);
            $permissions = Permission::whereIn('id', $request->input('permission'))->get();
            $role->syncPermissions($permissions);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something wrong.try again');
        }

        return redirect()->route('roles.index')
            ->with('success','Role created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        $role = Role::find($id);
        $permissions = $this->groupedPermissions();
        $selectedPermissions = $role->permissions->pluck('id')->toArray();
        return view('dashboard.roles.show',compact('role','permissions', 'selectedPermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = $this->groupedPermissions();
        $selectedPermissions = $role->permissions->pluck('id')->toArray();
        return view('dashboard.roles.edit',compact('role','permissions', 'selectedPermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
        $permissions = Permission::whereIn('id', $request->input('permission'))->get();
        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')
            ->with('success','Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
//        return redirect()->route('roles.index')
//            ->with('success','Role deleted successfully');
    }

    public function groupedPermissions()
    {
        return Permission::select('name', 'id')
            ->get()
            ->groupBy(function ($item) {
                $group = explode(' ', $item->name);
                return count($group) > 2 ? $group[2] : $group[1];
            })
            ->map(fn($items, $key) => [
                'name' => $key,
                'actions' => $items->pluck('name')->map(fn($row) => explode(' ', $row)[0])->toArray(),
                'permissions' => $items->pluck('id')->toArray()
            ])
            ->values();
    }
}
