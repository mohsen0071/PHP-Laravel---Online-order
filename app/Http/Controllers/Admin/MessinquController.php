<?php

namespace App\Http\Controllers\Admin;

use App\Messinqu;
use App\Userlog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessinquController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            'body' => 'required',
        ]);

        if($request->file('images'))
        {
            $imageUrl = $this->uploadFileInquiry($request->file('images'));
        }
        else
        {
            $imageUrl = '';
        }

        if($request->input('price'))
        {
            $price = str_replace(",","",$request->input('price'));
        }
        else
        {
            $price = 0;
        }

        if($request->input('deposit'))
        {
            $deposit = str_replace(",","",$request->input('deposit'));
        }
        else
        {
            $deposit = 0;
        }

        $messinqu = Messinqu::create(array_merge($request->only(
            'body',
            'pinquiry_id',
            'range',
            'length',
            'width'
        ),[
            'user_id' => auth()->user()->id,
            'images' => ($imageUrl),
            'deposit' => ($deposit),
            'price' => ($price),
        ]));

        $bodyLog =   ' ثبت پیام استعلام  ' . $messinqu->body;
        Userlog::create([
            'user_id' => auth()->user()->id,
            'body' => $bodyLog
        ]);

        alert()->success('','ثبت با موفقیت انجام شد');
        return redirect(route('pinquiries.show',['id' => $request->input('pinquiry_id')]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Messinqu  $messinqu
     * @return \Illuminate\Http\Response
     */
    public function show(Messinqu $messinqu)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Messinqu  $messinqu
     * @return \Illuminate\Http\Response
     */
    public function edit(Messinqu $messinqu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Messinqu  $messinqu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Messinqu $messinqu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Messinqu  $messinqu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Messinqu $messinqu)
    {
        //
    }
}
