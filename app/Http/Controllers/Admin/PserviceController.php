<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use App\Pservice;
use App\Userlog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PserviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product_services = Pservice::latest()->paginate(25);
        return view('Admin.product-services.all', compact('product_services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.product-services.create');
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
            'name' => 'required',
            'pservice_price' => 'required',
        ]);

        $price = str_replace(',','',$request->all('pservice_price'));

        $pservice = Pservice::create(array_merge($request->only(
            'name'
        ) , [
            'pservice_price' => $price['pservice_price'],
        ]));

        $bodyLog =   '-  ثبت خدمات محصولات     ' . $request->input('name');
        Userlog::create([
            'user_id' => auth()->user()->id,
            'body' => $bodyLog
        ]);


        alert()->success('','ثبت با موفقیت انجام شد');
        return redirect(route('product-service.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pservice  $Pservice
     * @return \Illuminate\Http\Response
     */
    public function show(Pservice $Pservice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pservice  $Pservice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Pservice = Pservice::find($id);
        return view('Admin.product-services.edit', compact('Pservice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pservice  $Pservice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Pservice = Pservice::find($id);

        $this->validate($request , [
            'name' => 'required',
            'pservice_price' => 'required',
        ]);

        $price = str_replace(',','',$request->all('pservice_price'));

        $Pservice->update(array_merge($request->only(
            'name'
        ) , [
            'pservice_price' => $price['pservice_price'],
        ]));


        $bodyLog = '  - ویرایش خدمات محصولات     '.  $request->input('name');
        Userlog::create([
            'user_id' => auth()->user()->id,
            'body' => $bodyLog
        ]);


        alert()->success('','ویرایش با موفقیت انجام شد');
        return redirect(route('product-service.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pservice  $Pservice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $found_pservices = Order::where('pservices', 'LIKE' , '%' . $id . '%')->count();


        $pservice = Pservice::where('id',$id)->first();

        if($found_pservices > 0)
        {
            alert()->error('','حذف امکان پذیر نیست');
        }
        else
        {
            $bodyLog =  '  - حذف خدمات محصولات     '.  $pservice->name;
            Userlog::create([
                'user_id' => auth()->user()->id,
                'body' => $bodyLog
            ]);

            Pservice::where('id', $id)->delete();
            alert()->success('','حذف با موفقیت انجام شد');
        }


        return redirect(route('product-service.index'));
    }
}
