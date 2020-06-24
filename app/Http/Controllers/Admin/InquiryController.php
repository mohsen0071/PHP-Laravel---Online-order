<?php

namespace App\Http\Controllers\Admin;

use App\Inquiry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InquiryController extends Controller
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
            $inquiries = Inquiry::where('title' , 'LIKE' , '%' . $keyword . '%')->latest()->paginate(50);
            return view('Admin.inquiries.all', compact('inquiries'));
        }
        else{
            $inquiries = Inquiry::latest()->paginate(50);
            return view('Admin.inquiries.all', compact('inquiries'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.inquiries.create');
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
            'title' => 'required',

        ]);

        $inquiry = Inquiry::create($request->all());

        alert()->success('','ثبت با موفقیت انجام شد');
        return redirect(route('inquiries.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inquiry  $inquiry
     * @return \Illuminate\Http\Response
     */
    public function show(Inquiry $inquiry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inquiry  $inquiry
     * @return \Illuminate\Http\Response
     */
    public function edit(Inquiry $inquiry)
    {
        return view('Admin.inquiries.edit', compact('inquiry'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inquiry  $inquiry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inquiry $inquiry)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);

        $inquiry = Inquiry::where('id', $inquiry->id)->update($request->only('title','body','status'));

        alert()->success('','ویرایش با موفقیت انجام شد');
        return redirect(route('inquiries.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inquiry  $inquiry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();
        alert()->success('','ثبت با موفقیت انجام شد');
        return redirect(route('inquiries.index'));
    }
}
