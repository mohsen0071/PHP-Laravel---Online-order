<?php

namespace App\Http\Controllers\Admin;

use App\Setting;
use App\Userlog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::where('id',1)->first();
        return view('Admin.settings.all', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'rules' => 'required',
        ]);

        $settings = Setting::where('id',1)->first();


        if($request->file('images'))
        {
            $imagesUrl = $this->uploadImages($request->file('images'),'category');
        }
        else
        {
            $imagesUrl = $settings->images;
        }

        Setting::where('id',1)->update([
            'name' => $request->input('name'),
            'tel' => $request->input('tel'),
            'address' => $request->input('address'),
            'rules' => $request->input('rules'),
            'guide' => $request->input('guide'),
            'images' => json_encode($imagesUrl)
        ]);

        $bodyLog = ' ویرایش تنظیمات سایت    ';
        Userlog::create([
            'user_id' => auth()->user()->id,
            'body' => $bodyLog
        ]);

        alert()->success('','ثبت با موفقیت انجام شد');
        return redirect(route('settings.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
