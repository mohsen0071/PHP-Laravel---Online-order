<?php

namespace App\Http\Controllers\Admin;

use App\Messinqu;
use App\Pinquiry;
use App\Userlog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PinquiryController extends Controller
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
            $pinquiries = Pinquiry::with('client','inquiry')->where('title' , 'LIKE' , '%' . $keyword . '%')->latest()->paginate(50);
        }
        else{
            $pinquiries = Pinquiry::with('client','inquiry')->latest()->paginate(50);
        }

        if($pinquiries)
        {
            foreach ($pinquiries as $key => $pin)
            {
                $lastMess = Messinqu::where('pinquiry_id', $pin->id)->latest()->first();
                if($lastMess)
                {
                    if($lastMess->user_id == auth()->user()->id)
                    {
                        $pinquiries[$key]['statusLastMess'] = '<small class="label label-warning">در انتظار پاسخ</small>';
                    }
                    else
                    {
                        $pinquiries[$key]['statusLastMess'] = '<small class="label label-info">کاربر پاسخ داده است </small>';
                    }
                }

            }
        }


   //     return $pinquiries;

        return view('Admin.pinquiries.all', compact('pinquiries'));

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pinquiry  $pinquiry
     * @return \Illuminate\Http\Response
     */
    public function show(Pinquiry $pinquiry)
    {
        $messInquries = Messinqu::with(['user','pinquiry'])
            ->where('pinquiry_id', $pinquiry->id)
            ->latest()->orderBy('id','DESC')->paginate(50);

        if(count($messInquries) > 0)
        {
            $title = $messInquries[0]->pinquiry->title;
            $pinqStatus = $messInquries[0]->pinquiry->status;
        }
        else
        {
            $title = '';
            $pinqStatus = 0;
        }

        return view('Admin.messinqus.create',compact('messInquries','title','pinqStatus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pinquiry  $pinquiry
     * @return \Illuminate\Http\Response
     */
    public function edit(Pinquiry $pinquiry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pinquiry  $pinquiry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pinquiry $pinquiry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pinquiry  $pinquiry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pinquiry $pinquiry)
    {
        Messinqu::where('pinquiry_id', $pinquiry->id)->delete();



        $bodyLog =   ' حذف استعلام  ' . $pinquiry->id;
        Userlog::create([
            'user_id' => auth()->user()->id,
            'body' => $bodyLog
        ]);

        $pinquiry->delete();

        alert()->success('', 'حذف با موفقیت انجام شد');
        return redirect(route('pinquiries.index'));
    }
}
