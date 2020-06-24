<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\Userlog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::latest()->paginate(25);
        return view('Admin.roles.all' ,  compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request , [
            'label' => 'required',
            'permission_id' => 'required'
        ]);

        $inputs = $request->all();

        $role = Role::create([
            'name' => 'admin',
            'label' => $inputs['label']
        ]);

        $role->permissions()->sync($request->input('permission_id'));

        $bodyLog = ' ثبت سطوح دسترسی    ';
        Userlog::create([
            'user_id' => auth()->user()->id,
            'body' => $bodyLog
        ]);

        alert()->success('','ثبت با موفقیت انجام شد');
        return redirect(route('roles.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions1 = $role->permissions()->get();

        $permissions = [];

        foreach ($permissions1 as $key=>$permission)
        {
            $permissions[$permission->name] = 1;
        }

      //  return $permissions['list-user'];
        return view('Admin.roles.edit' , compact('role','permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $this->validate($request , [
            'permission_id' => 'required',
            'label' => 'required'
        ]);

        $inputs = $request->all();

        $role->update([
            'name' => 'admin',
            'label' => $inputs['label']
        ]);

        $role->permissions()->sync($request->input('permission_id'));

        $bodyLog = ' ویرایش سطوح دسترسی    ';
        Userlog::create([
            'user_id' => auth()->user()->id,
            'body' => $bodyLog
        ]);


        alert()->success('','ویرایش با موفقیت انجام شد');
        return redirect(route('roles.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
       if(count($role->users()->get()) > 0){
           alert()->error('','حذف امکان پذیر نیست');
           return back();
       }else{
           alert()->success('','حذف با موفقیت انجام شد');
           $role->delete();
           return back();
       }
    }
}
