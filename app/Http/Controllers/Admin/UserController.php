<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Role;
use App\User;
use App\Userlog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class UserController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('roles')->where('level','admin')->orderBy('id','DESC')->paginate(15);
        return view('Admin.users.all' , compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_roles = Role::all();
        return view('Admin.users.create',compact('all_roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {

        $inputs = $request->only('name','email','mobile','status');
        $inputs['level'] = 'admin';
        $pass =  $request->input('password');

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'mobile' => $request->input('mobile'),
            'status' => $request->input('status'),
            'level' => 'admin',
            'password' => bcrypt($pass)
        ]);

        $user->roles()->sync($request->input('role'));
        alert()->success('','ثبت با موفقیت انجام شد');
        return redirect(route('users.index'));
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
    public function edit(User $user)
    {
        $all_roles = Role::all();
        $roles = Role::get();
        $user_role = $user->roles()->get();
        $user_role = $user_role[0]->id;
        return view('Admin.users.edit', compact('user','all_roles','user_role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => [
                'required',
                Rule::unique('users')->ignore($user->id),
            ],
            'mobile' => [
                'required',
                'digits:11',
                Rule::unique('users')->ignore($user->id),
                ],
            'password' => 'nullable|min:8'
        ]);

        $inputs = $request->only('name','username','email','mobile','status','password');

        if ($inputs['password']) {
            $inputs['password'] = bcrypt($inputs['password']);
        } else {
            unset($inputs['password']);
        }


        $user->update($inputs);
        $user->roles()->sync($request->input('role'));
        alert()->success('','ویرایش با موفقیت انجام شد');
        return redirect(route('users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if(count($user->notifs()->get()) > 0){
            alert()->error('','حذف امکان پذیر نیست');
            return back();
        }else{
            $user->delete();
            $bodyLog =  ' حذف مشتری ' .  $user->name ;
            Userlog::create([
                'user_id' => auth()->user()->id,
                'body' => $bodyLog
            ]);

            alert()->success('','حذف با موفقیت انجام شد');
            return back();
        }
    }

    public function profile()
    {
        $userId = auth()->user()->id;
        $user = User::where('id',$userId)->first();
        return view('Admin.users.profile',compact('user'));
    }

    public function employeeUpdate(Request $request){

        $user = User::find(auth()->user()->id);

        $this->validate($request, [
            'name' => 'required',
            'email' => [
                'required',
                Rule::unique('users')->ignore($user->id),
            ],
            'mobile' => [
                'required',
                'digits:11',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|min:8'
        ]);


        if($request->file('images'))
        {
            $imagesUrl = $this->uploadImagesUser($request->file('images'),'users');
        }
        else
        {
            $imagesUrl = $user->images;
        }

        if($request->input('password'))
        {
            User::where('id',auth()->user()->id)->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'mobile' => $request->input('mobile'),
                'images' => $imagesUrl,
            ]);
        }
        else
        {
            User::where('id',auth()->user()->id)->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'images' => $imagesUrl,
            ]);
        }


        return redirect()->back();
    }
}
