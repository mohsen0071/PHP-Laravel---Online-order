<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Order;
use App\Pservice;
use App\Sheet;
use App\Transaction;
use App\User;
use App\Userlog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function PHPSTORM_META\elementType;

class OrderController extends AdminController
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

            $orders = Order::with(['product'])
                ->where('order_number' , 'LIKE' , '%' . $keyword . '%')
                ->orWhere('name' , 'LIKE' , '%' . $keyword . '%')
                ->orWhereHas('category', function ( $query ) use ($keyword){
                    $query->where('name' , 'LIKE' , '%' . $keyword . '%' );
                })
                ->orWhereHas('client', function ( $query ) use ($keyword){
                    $query->where('name' , 'LIKE' , '%' . $keyword . '%' );
                })
           //     ->orderby('status', 'asc')
           //     ->orderby('status_sheets', 'asc')
                ->latest()
                ->paginate(50);

        }
        elseif(request('status'))
        {
            $keyword = request('status');
            if($keyword == 2)
            {
                $keyword = 0;
            }
            $orders = Order::with(['product'])
                ->where('status' , $keyword )
                ->latest()
                ->paginate(50);
        }
        else
            {
            $orders = Order::with(['category','user','product','client'])
              //  ->orderby('status', 'asc')
             //   ->orderby('status_sheets', 'asc')
                ->latest()
                ->paginate(50);
        }






        foreach ($orders as $key => $order)
        {

            $clients = User::find($order->client_id);

            $orders[$key]['client_name'] =  $clients->name;
            $orders[$key]['sumAll'] = $this->calculateOrder($order);
        }

        return view('Admin.orders.all', compact('orders'));
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

        $order_number = Order::orderby('id', 'desc')->first();

        if($order_number)
        {
            $order_number = $this->orderNumber($order_number->id);
        }
        else
        {
            $order_number = $this->orderNumber(0);
        }

        $this->validate($request, [
            'name' => 'required',
            'category_id' => 'required',
            'product_id' => 'required',
            'unit' => 'required|numeric',
            'length' => 'required',
            'width' => 'required',
            'range' => 'required',
        ]);

        if($request->only('urgent')){ $urgent = 1;  }  else   { $urgent = 0;  }

        if($request->input('customInputLength')) { $length = $request->input('customInputLength'); } else { $length = $request->input('length'); }
        if($request->input('customInputWidth')) { $width = $request->input('customInputWidth'); } else { $width = $request->input('width'); }


        if($request->hasfile('allfiles'))
        {
            $clientName = User::find($request->input('client_id'));
            $categoryName = Category::find($request->input('category_id'));
            $clientName = $request->input('client_id').'-'.$order_number.'-'.$clientName->name.'-'.time().'-'.$categoryName->name.'-';
            foreach ($request->file('allfiles') as $key => $file)
            {
                // $data[$key] = $file->getClientOriginalName();
                $dataUrlImage[$key] = $this->uploadOrderImages($file,$clientName);
            }
        }

        if($request->input('pservice_id'))
        {
            $pservices = $request->input('pservice_id');

            foreach ($pservices as $key => $pservice)
            {
                $dataPservices[] = $pservice;
            }
        }
        else
        {
            $dataPservices = [];
        }


        if($request->input('price_design'))
        {
            $price_design = str_replace(',','',$request->input('price_design'));
        }
        else
        {
            $price_design = 0;
        }
        $getCategoryId = explode(",",$request->input('category_id'));
      //  return $getCategoryId[0];
        $order = Order::create(
            array_merge($request->only(
                'name',
                'product_id',
                'range',
                'price_design',
                'body',
                'unit',
                'client_id'
            ),
                [
                    'category_id' => $getCategoryId[0],
                    'pservices' => json_encode($dataPservices),
                    'price_design' => $price_design,
                    'images' => $dataUrlImage,
                    'length' => $length,
                    'width' => $width,
                    'urgent' => $urgent,
                    'user_id' => auth()->user()->id,
                    'order_number' => $order_number
                ]));

        $bodyLog =   ' ثبت سفارش    ' . $order_number;
        Userlog::create([
            'user_id' => auth()->user()->id,
            'body' => $bodyLog
        ]);

        alert()->success('','ثبت با موفقیت انجام شد');
        return redirect(route('orders.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {

        $orders = Order::with(['category','user','product'])->where('id',$order->id)->first();
        $client = User::find($orders->client_id);

        $allPservice ='';
        $allPservicePrice = 0;
        if($orders->pservices){
            foreach (json_decode($orders->pservices) as $key => $pservice)
            {
                $pserviceTitle = Pservice::find($pservice);
                $allPservice .= '<span> '.$pserviceTitle->name.' </span>--';
                $allPservicePrice += $pserviceTitle->pservice_price;
            }
        }

        if($orders->urgent == 1)
        {
            $orderPrice = $orders->product->urgent_price;
        }
        else
        {
            $orderPrice = $orders->product->price;
        }

        $pservicePrice = ($orders->range / 1000) * $orders->category->pservice_unit * $allPservicePrice;
        $productPrice =  $this->calculateOrder($orders);


        return view('Admin.orders.show',
            compact('orders','client','allPservice','allPservicePrice','pservicePrice','productPrice')
        );

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {

        if($request->hasfile('allfiles'))
        {
            $clientName = User::find($request->input('client_id'));
            $categoryName = Category::find($request->input('category_id'));
            $order_number = $request->input('order_number');

            $clientName = $request->input('client_id').'-'.$order_number.'-'.$clientName->name.'-'.time().'-'.$categoryName->name.'-';

            $dataUrlImage = $order->images;

            foreach ($request->file('allfiles') as $key => $file)
            {
                $dataUrlImage[$key] = $this->uploadOrderImages($file,$clientName);
            }

            $order->update([
                'images' => $dataUrlImage
            ]);

            $bodyLog =   $order_number .' ویرایش فایل های سفارش    ';
            Userlog::create([
                'user_id' => auth()->user()->id,
                'body' => $bodyLog
            ]);

            alert()->success('','بارگذاری فایل های جدید با موفقیت انجام شد');
            return redirect()->back();

        }
        else
        {
            alert()->error('','فایل جدیدی برای بارگذاری انتخاب نشده است!');
            return redirect()->back();
        }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {

        $transaction = Transaction::with('client')->where('order_id',$order->id)->orderBy('id', 'asc')->first();
        if($transaction) {
            $bodyTransaction = 'لغو سفارش: ' . $order->order_number;

            $user = User::where('id', $transaction->client->id)->first();

            $rest_balance = $user->balance;

            $discount = $transaction->discount;

            $deposit = $transaction->deposit;

            $price = $transaction->price;

            if ($price < 0) {
                $price = str_replace("-", "", $price);
            }

            $rrest_pprice = ($rest_balance + $price) - ($discount);

            //  $price = ($price - $discount);

            $transaction = Transaction::create(
                [
                    'order_id' => $order->id,
                    'user_id' => auth()->user()->id,
                    'client_id' => $user->id,
                    'discount' => $discount,
                    'deposit' => $deposit,
                    'body' => $bodyTransaction,
                    'rest_balance' => $rrest_pprice,
                    'transaction_type' => 5,
                    'payment_type' => 6,
                    'price' => $price

                ]); // transaction_type = 5 لغو تراکنش

            $user = User::where('id', $user->id)->first();
            $user->balance = $rrest_pprice;
            $user->save();

            if ($order->sheet_id) {
                $sheet = Sheet::where('id', $order->sheet_id)->first();
                $sheet->used_unit -= $order->unit;
                $sheet->remining_unit += $order->unit;
                $sheet->save();
            }

        }




        $order->delete();

        $bodyLog = ' حذف سفارش    ' .  $order->order_number;
        Userlog::create([
            'user_id' => auth()->user()->id,
            'body' => $bodyLog
        ]);

        alert()->success('','لغو سفارش با موفقیت انجام شد');
        return redirect(route('transactions.index'));

    }

    public function client_order($client_id)
    {
        if(request('search'))
        {
            $keyword = request('search');

            $client = User::find($client_id);
            $orders = Order::with(['user','product'])
                ->where('client_id',$client_id)
                ->where('order_number' , 'LIKE' , '%' . $keyword . '%')
                ->orWhere('name' , 'LIKE' , '%' . $keyword . '%')
                ->orWhereHas('category', function ( $query ) use ($keyword){
                    $query->where('name' , 'LIKE' , '%' . $keyword . '%' );
                })
                ->latest()
                ->paginate(25);

        }
        else{
            $client = User::find($client_id);
            $orders = Order::with(['category','user','product'])->where('client_id',$client_id)->latest()->paginate(50);
        }

         return view('Admin.orders.clients_order', compact('orders','client'));
    }

    public function editFiles($id)
    {
        $orders = Order::with(['category','user','product'])->where('id',$id)->first();

        return view('Admin.orders.show_files',
            compact('orders')
        );
    }

    public function storeFiles(Request $request)
    {

        if($request->hasfile('allfiles'))
        {
            $clientName = User::find($request->input('client_id'));
            $categoryName = Category::find($request->input('category_id'));
            $order_number = $request->input('order_number');

            $clientName = $request->input('client_id').'-'.$order_number.'-'.$clientName->name.'-'.time().'-'.$categoryName->name.'-';

            foreach ($request->file('allfiles') as $key => $file)
            {
                $dataUrlImage[$key] = $this->uploadOrderImages($file,$clientName);
            }
        }

    }
}
