<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Province;
use App\User;
use App\Userlog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class ClientController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(request('search'))
        {
            $keyword = request('search');

            $clients = User::search($keyword)->where('level','user')->latest()->paginate(25);
         //   return $clients;
            return view('Admin.clients.all' , compact('clients'));
        }
        else{
            $clients = User::with(['province','city'])->where('level','user')->latest()->paginate(25);
           // return json_decode($clients[0]->images)->thumb;
            return view('Admin.clients.all' , compact('clients'));
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provinces = Province::all();
        return view('Admin.clients.create', compact('provinces'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {

        $this->validate($request, [
            'name' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',


            'email' => [
                Rule::unique('users')->ignore($user->id),
            ],
            'mobile' => [
                'required',
                'digits:11',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'required|min:8'
        ]);

        $inputs = $request->all();

        if($request->file('images'))
        {
            $imagesUrl = $this->uploadImagesUser($request->file('images'),'users');
        }
        else
        {
            $imagesUrl = '';
        }


         User::create([
            'name' => $inputs['name'],
            'company' => $inputs['company'],
            'email' => $inputs['email'],
            'mobile' => $inputs['mobile'],
            'tel' => $inputs['tel'],
            'national_code' => $inputs['national_code'],
            'postal_code' => $inputs['postal_code'],
            'address' => $inputs['address'],
            'province_id' => $inputs['province_id'],
            'city_id' => $inputs['city_id'],
            'images' => $imagesUrl,
            'password' => Hash::make($inputs['password']),
        ]);

        $bodyLog =  ' افزودن مشتری '. $inputs['name'] ;
        Userlog::create([
            'user_id' => auth()->user()->id,
            'body' => $bodyLog
        ]);

        return redirect(route('clients.index'));
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
        $provinces = Province::all();
        $user = User::find($id);
        return view('Admin.clients.edit', compact('provinces','user'));
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
        $user = User::find($id);

        $this->validate($request, [
            'name' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',


            'email' => [
                Rule::unique('users')->ignore($user->id),
            ],
            'mobile' => [
                'required',
                'digits:11',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|min:8'
        ]);

        $inputs = $request->all();

        if($request->file('images'))
        {
            $imagesUrl = $this->uploadImagesUser($request->file('images'),'users');
        }
        else
        {
            $imagesUrl = $user->images;
        }

        if ($inputs['password'])
        {
            User::where('id', $user->id)->update([
                'name' => $inputs['name'],
                'company' => $inputs['company'],
                'email' => $inputs['email'],
                'mobile' => $inputs['mobile'],
                'tel' => $inputs['tel'],
                'national_code' => $inputs['national_code'],
                'postal_code' => $inputs['postal_code'],
                'address' => $inputs['address'],
                'province_id' => $inputs['province_id'],
                'city_id' => $inputs['city_id'],
                'status' => $inputs['status'],
                'user_type' => $inputs['user_type'],
                'images' => $imagesUrl,
                'password' => Hash::make($inputs['password']),
            ]);
        }
        else
        {
            User::where('id', $user->id)->update([
                'name' => $inputs['name'],
                'company' => $inputs['company'],
                'email' => $inputs['email'],
                'mobile' => $inputs['mobile'],
                'tel' => $inputs['tel'],
                'national_code' => $inputs['national_code'],
                'postal_code' => $inputs['postal_code'],
                'address' => $inputs['address'],
                'province_id' => $inputs['province_id'],
                'city_id' => $inputs['city_id'],
                'status' => $inputs['status'],
                'user_type' => $inputs['user_type'],
                'images' => $imagesUrl,
            ]);
        }

        $bodyLog =  ' ویرایش مشتری '.$inputs['name'];
        Userlog::create([
            'user_id' => auth()->user()->id,
            'body' => $bodyLog
        ]);

        return redirect(route('clients.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {

    }

    public function order($id)
    {
        $user = User::where('id',$id)->first();
        $categories = Category::where('depth','0')->get();

        return view('Admin.orders.order', compact('user', 'categories'));
    }
}
