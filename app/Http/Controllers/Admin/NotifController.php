<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\NotifRequest;
use App\Notif;
use App\User;
use App\Userlog;
use Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotifController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $notifs = Notif::latest()->paginate(10);
        return view('Admin.notifs.all', compact('notifs'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.notifs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NotifRequest $request)
    {

        $imagesUrl = $this->uploadImages($request->file('images'),'images');
        auth()->user()->notifs()->create(array_merge($request->all() , [ 'images' => $imagesUrl]));

        $bodyLog =   ' ثبت اطلاعیه   '.$request->input('title') ;
        Userlog::create([
            'user_id' => auth()->user()->id,
            'body' => $bodyLog
        ]);

        alert()->success('','ثبت با موفقیت انجام شد');
        return redirect(route('notifs.index'));
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
    public function edit(Notif $notif)
    {
        return view('Admin.notifs.edit' , compact('notif'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NotifRequest $request, Notif $notif)
    {
        $file = $request->file('images');
        $inputs = $request->all();

        if($file) {
            $inputs['images'] = $this->uploadImages($request->file('images'));
        } else {
            $inputs['images'] = $notif->images;
           // $inputs['images']['thumb'] = $inputs['imagesThumb'];

        }

     //   unset($inputs['imagesThumb']);
        $notif->update($inputs);

        $bodyLog =  ' ویرایش اطلاعیه   ' .  $request->input('title') ;
        Userlog::create([
            'user_id' => auth()->user()->id,
            'body' => $bodyLog
        ]);

        alert()->success('','ویرایش با موفقیت انجام شد');
        return redirect(route('notifs.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notif $notif)
    {
        $notif->delete();
        $bodyLog = ' حذف اطلاعیه   ' . $notif->title;
        Userlog::create([
            'user_id' => auth()->user()->id,
            'body' => $bodyLog
        ]);
        alert()->success('','حذف با موفقیت انجام شد');
        return redirect(route('notifs.index'));
    }
}
