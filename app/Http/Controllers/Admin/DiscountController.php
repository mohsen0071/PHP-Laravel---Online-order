<?php

namespace App\Http\Controllers\Admin;

use App\Discount;
use App\Product;
use App\User;
use App\Userlog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discounts = Discount::latest()->orderBy('status','ASC')->orderBy('expireDate','ASC')->paginate(50);

        return view('Admin.discounts.all', compact('discounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::select('id','name','mobile')->where('level','user')->get();
        $products = Product::with(['category'])->get();
      //  return $products;
        return view('Admin.discounts.create',compact('users','products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Discount $discount)
    {

        $this->validate($request, [
            'amount' => 'required|numeric|min:1|max:100'
        ]);


        $minAmount = str_replace(",","",$request->input('minAmount'));
        $maxAmount = str_replace(",","",$request->input('maxAmount'));

        if($request->input('client_group'))
        {
            $client_group = $request->input('client_group');
        }
        else
        {
            $client_group = [];
        }

        if($request->input('product_group'))
        {
            $product_group = $request->input('product_group');
        }
        else
        {
            $product_group = [];
        }

        $discount = Discount::create(array_merge($request->all(),[
            'minAmount' => $minAmount,
            'maxAmount' => $maxAmount,
            'client_group' => ($client_group),
            'product_group' => ($product_group),
        ]));

        $bodyLog =   ' افزودن تخفیف ' . $discount->id ;
        Userlog::create([
            'user_id' => auth()->user()->id,
            'body' => $bodyLog
        ]);


        alert()->success('','ثبت با موفقیت انجام شد');
        return redirect(route('discounts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function show(Discount $discount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function edit(Discount $discount)
    {
        $users = User::select('id','name','mobile')->where('level','user')->get();
        $products = Product::with(['category'])->get();
        return view('Admin.discounts.edit' , compact('discount','users','products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Discount $discount)
    {
        $this->validate($request, [
            'amount' => 'required',
        ]);

        $minAmount = str_replace(",","",$request->input('minAmount'));
        $maxAmount = str_replace(",","",$request->input('maxAmount'));

        if($request->input('client_group'))
        {
            $client_group = $request->input('client_group');
        }
        else
        {
            $client_group = [];
        }

        if($request->input('product_group'))
        {
            $product_group = $request->input('product_group');
        }
        else
        {
            $product_group = [];
        }

        Discount::where('id', $discount->id)->update((
            array_merge($request->only(
                'amount_type',
                'amount',
                'type',
                'expireDate',
                'status',
                'body'
            ),
                [
                    'minAmount' => $minAmount,
                    'maxAmount' => $maxAmount,
                    'client_group' => json_encode($client_group),
                    'product_group' => json_encode($product_group),
                ])
        ));

        $bodyLog =   ' ویرایش تخفیف ' . $discount->id ;
        Userlog::create([
            'user_id' => auth()->user()->id,
            'body' => $bodyLog
        ]);


        alert()->success('','ویرایش با موفقیت انجام شد');
        return redirect(route('discounts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();

        $bodyLog =  ' حذف تخفیف ' .  $discount->id;
        Userlog::create([
            'user_id' => auth()->user()->id,
            'body' => $bodyLog
        ]);


        alert()->success('','حذف با موفقیت انجام شد');
        return redirect(route('discounts.index'));
    }
}
