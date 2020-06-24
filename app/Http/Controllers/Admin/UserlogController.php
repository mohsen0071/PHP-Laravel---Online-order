<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Userlog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request('client_id') != '')
        {
            $dateFrom = request('date_from');
            $dateTo = request('date_to');

            $dateFrom = $this->shamsiToMiladi($dateFrom).' 00:00:00';
            $dateTo = $this->shamsiToMiladi($dateTo).' 23:59:59';

            $userLogs = Userlog::with(['user'])
                ->where('created_at','>=', $dateFrom)
                ->where('created_at','<=', $dateTo)
                ->where('user_id',request('client_id'))
                ->orderby('id','desc')
                ->paginate(50);
        }
        elseif(request('date_from'))
        {
            $dateFrom = request('date_from');
            $dateTo = request('date_to');

            $dateFrom = $this->shamsiToMiladi($dateFrom).' 00:00:00';
            $dateTo = $this->shamsiToMiladi($dateTo).' 23:59:59';

            $userLogs = Userlog::with(['user'])
                ->where('created_at','>=', $dateFrom)
                ->where('created_at','<=', $dateTo)
                ->orderby('id','desc')
                ->paginate(50);


        }
        else
        {
            $userLogs = Userlog::with(['user'])
                ->orderby('id','desc')
                ->paginate(50);
        }


        $users = User::select('id','name','mobile')->where('level','admin')->get();
        return view('Admin.userlogs.all',compact('userLogs','users'));
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
     * @param  \App\Userlog  $userlog
     * @return \Illuminate\Http\Response
     */
    public function show(Userlog $userlog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Userlog  $userlog
     * @return \Illuminate\Http\Response
     */
    public function edit(Userlog $userlog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Userlog  $userlog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Userlog $userlog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Userlog  $userlog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Userlog $userlog)
    {
        //
    }
}
