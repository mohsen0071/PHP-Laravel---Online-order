<?php

namespace App\Http\Controllers\Admin;

use App\Shipping;
use App\Userlog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shippings = Shipping::with(['client','order'])
            ->latest()
            ->paginate(50);

        if(request('status'))
        {
            $keyword = request('status');
            if($keyword == 1)
            {
                $shippings = Shipping::with(['client','order'])
                    ->where('shipping_number','=',null)
                    ->latest()
                    ->paginate(50);
            }
            else
            {
                $shippings = Shipping::with(['client','order'])
                    ->where('shipping_number','<>','')
                    ->latest()
                    ->paginate(50);
            }

        }

        return view('Admin.shippings.all', compact('shippings'));
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
            'shipping_way' => 'required',
            'shipping_name' => 'required',
            'shipping_number' => 'required',
            'ship_id' => 'required',
        ]);

        $shippings = $request->input('ship_id');

        foreach ($shippings as $shipp)
        {
            Shipping::where('id',$shipp)->update([
                'shipping_way' => $request->input('shipping_way'),
                'shipping_name' => $request->input('shipping_name'),
                'shipping_number' => $request->input('shipping_number')
            ]);
        }

        $bodyLog =   ' - شماره باربری -  ویرایش ارسال درخواست کار'. $request->input('shipping_number');
        Userlog::create([
            'user_id' => auth()->user()->id,
            'body' => $bodyLog
        ]);

        alert()->success('', 'درخواست  با موفقیت ثبت شد');
        return redirect(route('shippings.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function show(Shipping $shipping)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function edit(Shipping $shipping)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shipping $shipping)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shipping $shipping)
    {
        //
    }
}
