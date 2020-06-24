<?php

namespace App\Http\Controllers;

use App\Category;
use App\Discount;
use App\Messinqu;
use App\Notif;
use App\Order;
use App\Payment;
use App\Pinquiry;
use App\Product;
use App\Province;
use App\Pservice;
use App\Setting;
use App\Sheet;
use App\Shipping;
use App\Transaction;
use App\User;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    public function index()
    {
        $notifs = Notif::with(['user'])->latest()->get();

        $order_paid = Order::where('client_id', auth()->user()->id)->where('status', 1)->count();

        $order_unpaid = Order::where('client_id', auth()->user()->id)->where('status', 0)->count();

        $pinquiries = Pinquiry::where('client_id', auth()->user()->id)->count();

        $orders = Order::with(['category','user','product','client'])
            ->where('client_id', auth()->user()->id)
            ->latest()
            ->paginate(10);

        return view('User.panel',compact('order_paid','order_unpaid','orders','notifs','pinquiries'));
    }

    public function singleNotif($id)
    {
        $notif = Notif::where('id',$id)->first();

        $notif->viewCount += 1;
        $notif->save();

        return view('User.show_notif',compact('notif'));
    }

    public function showOrder($id)
    {
        $order = Order::find($id);

        $orders = Order::with(['category','user','product'])
            ->where('client_id', auth()->user()->id)
            ->where('id',$order->id)->first();

        if(!$orders){
            return abort(404);
        }

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


        return view('User.show_order',
            compact('orders','client','allPservice','allPservicePrice','pservicePrice','productPrice')
        );


    }

    public function editUser()
    {
        $user = User::find(auth()->user()->id);
        $provinces = Province::all();
        return view('User.edit_profile',compact('user','provinces'));
    }

    public function clientUpdate(Request $request)
    {
        $user = User::find(auth()->user()->id);

        $this->validate($request, [
            'name' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',


            'email' => [
                Rule::unique('users')->ignore($user->id),
            ],
            'mobile' => [
                'required',
                'digits:11',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|min:8',
            'address' => 'required'
        ]);

        $inputs = $request->all();

        if($request->file('images'))
        {
            $imagesUrl = $this->uploadImagesUser($request->file('images'),'users');
        }
        else
        {
            $imagesUrl = $user->images;
        }

        if ($inputs['password'])
        {
            User::where('id', $user->id)->update([
                'name' => $inputs['name'],
                'company' => $inputs['company'],
                'email' => $inputs['email'],
                'mobile' => $inputs['mobile'],
                'tel' => $inputs['tel'],
                'national_code' => $inputs['national_code'],
                'postal_code' => $inputs['postal_code'],
                'address' => $inputs['address'],
                'province_id' => $inputs['province_id'],
                'city_id' => $inputs['city_id'],
                'images' => $imagesUrl,
                'password' => Hash::make($inputs['password']),
            ]);
        }
        else
        {
            User::where('id', $user->id)->update([
                'name' => $inputs['name'],
                'company' => $inputs['company'],
                'email' => $inputs['email'],
                'mobile' => $inputs['mobile'],
                'tel' => $inputs['tel'],
                'national_code' => $inputs['national_code'],
                'postal_code' => $inputs['postal_code'],
                'address' => $inputs['address'],
                'province_id' => $inputs['province_id'],
                'city_id' => $inputs['city_id'],
                'images' => $imagesUrl,
            ]);
        }

        alert()->success('','ویرایش پروفایل با موفقیت انجام شد');
        return redirect()->back();
    }

    public function newOrder()
    {
        $user = User::find(auth()->user()->id);
        $categories = Category::where('depth','0')->get();
        return view('User.neworder', compact('user', 'categories'));
    }

    public function storeNewOrder(Request $request)
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
            $clientName = User::find(auth()->user()->id);
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
                'unit'

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
                    'client_id' => auth()->user()->id,
                    'order_number' => $order_number
                ]));

        alert()->success('','ثبت با موفقیت انجام شد');
        return redirect(route('user.allOrder'));

    }

    public function allOrder()
    {

        $client = User::find(auth()->user()->id);

        if(request('search'))
        {
            $keyword = request('search');

            $orders = Order::with(['user','product'])
                ->where('client_id',$client->id)
                ->where('order_number' , 'LIKE' , '%' . $keyword . '%')
                ->orWhere('name' , 'LIKE' , '%' . $keyword . '%')
                ->orWhereHas('category', function ( $query ) use ($keyword){
                    $query->where('name' , 'LIKE' , '%' . $keyword . '%' );
                })
                ->latest()
                ->orderby('status', 'asc')
                ->paginate(25);
        }
        else{
            $orders = Order::with(['category','user','product'])->where('client_id',$client->id)
                ->orderby('status', 'asc')
                ->latest()
                ->paginate(50);
        }



        foreach ($orders as $key => $order)
        {

            $orders[$key]['rowPrice'] = $this->calculateOrder($order);

            $discount = $this->getDiscount($order->product_id,$order->client_id);

            if($discount)
            {
                $orders[$key]['discount'] = ($this->calculateOrder($order) * ($discount)) / 100;
            }

        }

        return view('User.all_order', compact('orders','client'));
    }

    public function transactions()
    {
        $client_id = auth()->user()->id;

        if(request('date_from') && request('transaction_type'))
        {
            $dateFrom = request('date_from');
            $dateTo = request('date_to');

            $dateFrom = $this->shamsiToMiladi($dateFrom).' 00:00:00';
            $dateTo = $this->shamsiToMiladi($dateTo).' 23:59:59';

            $transactions = Transaction::with(['user','client','order'])
                ->where('client_id',$client_id)
                ->where('created_at','>=', $dateFrom)
                ->where('created_at','<=', $dateTo)
                ->where('transaction_type',request('transaction_type'))
                ->orderby('id','desc')
                ->paginate(50);

        }
        elseif(request('date_from'))
        {
            $dateFrom = request('date_from');
            $dateTo = request('date_to');

            $dateFrom = $this->shamsiToMiladi($dateFrom).' 00:00:00';
            $dateTo = $this->shamsiToMiladi($dateTo).' 23:59:59';

            $transactions = Transaction::with(['user','client','order'])
                ->where('client_id',$client_id)
                ->where('created_at','>=', $dateFrom)
                ->where('created_at','<=', $dateTo)
                ->orderby('id','desc')
                ->paginate(50);


        }
        else
        {
            $transactions = Transaction::with(['user','client','order'])->where('client_id',$client_id)->orderby('id','desc')->paginate(50);

        }

        $sumall = 0;
        if($transactions && request('date_from')) {
            foreach ($transactions as $transaction) {
                $discount = str_replace(",", "", $transaction->discount);
                $deposit = str_replace(",", "", $transaction->deposit);
                $sumall += ($transaction->price) + ($discount) + ($deposit);

            }
        }
        $client = User::find($client_id);
        return view('User.transactions',compact('transactions','client','sumall'));

    }

    public function increaseBalance()
    {
        return view('User.increase_balance');
    }

    public function increase(Request $request)
    {
        $this->validate($request, [
            'price' => 'required'
        ]);
        return 'send to bank';
    }

    public function theRules()
    {
        $rules = Setting::latest()->first();
        return view('User.the_rules', compact('rules'));
    }

    public function priceList()
    {
        if(request('search'))
        {
            $keyword = request('search');
            $products = Product::search($keyword)->latest()->orderBy('category_id')->paginate(25);
            return view('User.price_list' , compact('products'));
        }
        else
        {
            $products = Product::with('category')->latest()->orderBy('category_id')->paginate(25);
            //  return $products;
            return view('User.price_list' , compact('products'));
        }
    }

    public function paymentAccount(Request $request)
    {
        $this->validate(request() , [
            'order_id' => 'required'
        ]);

        $orders = $request->input('order_id');

        foreach ($orders as $orderId)
        {

            $order = Order::where('id',$orderId)->first();

            $getSheetOpen = Sheet::where('category_id', $order->category_id)
                ->where('status', 1)
                ->count();

            if ($getSheetOpen == 0)
            {
                // empty form not exist

                $getSheetCount = Category::where('id', $order->category_id)->first();

                $sheet = Sheet::create(array_merge(['category_id' => $order->category_id,
                    'user_id' => auth()->user()->id,
                    'used_unit' => 0,
                    'remining_unit' => $getSheetCount->sheet_count,
                    'status' => 1,]));

                $sheet->used_unit += $order->unit;
                $sheet->remining_unit -= $order->unit;
                $sheet->save();

                $order->sheet_id = $sheet->id;
                $order->save();
            }

            else
            {
                // empty form exist

                $getSheetOpen = Sheet::where('category_id', $order->category_id)
                    ->where('status', 1)
                    ->where('remining_unit', '>=', $order->unit)
                    ->orderby('remining_unit', 'asc')
                    ->first();

                if ($getSheetOpen) {

                    $getSheetOpen->used_unit += $order->unit;
                    $getSheetOpen->remining_unit -= $order->unit;
                    $getSheetOpen->save();

                    $order->sheet_id = $getSheetOpen->id;
                    $order->save();

                } else {

                    $getSheetCount = Category::where('id', $order->category_id)->first();

                    $sheet = Sheet::create(array_merge([
                        'category_id' => $order->category_id,
                        'user_id' => auth()->user()->id,
                        'used_unit' => 0,
                        'remining_unit' => $getSheetCount->sheet_count,
                        'status' => 1,
                    ]));

                    $sheet->used_unit += $order->unit;
                    $sheet->remining_unit -= $order->unit;
                    $sheet->save();

                    $order->sheet_id = $sheet->id;
                    $order->save();
                }

            }




            $bodyTransaction = 'شماره سفارش: ' . $order->order_number;
            $user = User::where('id',auth()->user()->id)->first();
            $rest_balance = $user->balance;

            $discount = $this->getDiscount($order->product_id,$order->client_id);

            if($discount)
            {
                $discount = ($this->calculateOrder($order) * ($discount)) / 100;
            }
            else
            {
                $discount = 0;
            }

            $deposit = 0;

            $price = $this->calculateOrder($order);
            $rrest_pprice = ($rest_balance - $price) + $discount;
            $transaction = Transaction::create(
                [
                    'order_id' => $order->id,
                    'user_id' => auth()->user()->id,
                    'client_id' => auth()->user()->id,
                    'discount' => $discount,
                    'deposit' => $deposit,
                    'body' => $bodyTransaction,
                    'rest_balance' => ($rrest_pprice),
                    'transaction_type' => 4,
                    'payment_type' => 5,
                    'price' => -($price)

                ]); // transaction_type = 4 حساب کاربری

            $user = User::where('id',auth()->user()->id)->first();
            $user->balance = $rrest_pprice;
            $user->save();


            Order::where('id', $orderId)->update([
                'status' => 1,
                'status_sheets' => 1
            ]);


        }

        alert()->success('', 'پرداخت با موفقیت انجام شد');
        return redirect(route('user.allOrder'));
    }

    public  function payment(Request $request)
    {

        $this->validate(request() , [
            'order_id' => 'required'
        ]);

        $orders = $request->input('order_id');

        $sumAllOrder = 0;
        $sumAllDiscount = 0;
        $desc = '';
        foreach ($orders as $order)
        {
            $getOrder = Order::where('id', $order)->first();

            $desc .= ': پرداخت سفارش'.$getOrder->order_number;

            $discount = $this->getDiscount($getOrder->product_id,$getOrder->client_id);

            if($discount)
            {
                $discount = ($this->calculateOrder($getOrder) * ($discount)) / 100;
            }
            else
            {
                $discount = 0;
            }

            $sumAllDiscount += $discount;

            $sumAllOrder += $this->calculateOrder($getOrder);
        }

        $price = ($sumAllOrder - $sumAllDiscount) / 10; // Convert to Toman

        $MerchantID = '3a59d85e-f67e-11e6-b515-005056a205be'; //Required

        $Description = $desc; // Required
        $Email = auth()->user()->email; // Optional
        $Mobile = auth()->user()->mobile; // Optional

        $CallbackURL = 'http://localhost:8000/user/payment'; // Required

        $client = new \nusoap_client('https://www.zarinpal.com/pg/services/WebGate/wsdl', 'wsdl');
        $client->soap_defencoding = 'UTF-8';
        $result = $client->call('PaymentRequest', [
            [
                'MerchantID'     => $MerchantID,
                'Amount'         => $price,
                'Description'    => $Description,
                'Email'          => $Email,
                'Mobile'         => $Mobile,
                'CallbackURL'    => $CallbackURL,
            ],
        ]);

        //Redirect to URL You can do it also by creating a form
        if ($result['Status'] == 100) {
            Payment::create([
                'user_id' => auth()->user()->id,
                'resnumber' => $result['Authority'],
                'price' => $price,
                'discount' => ($sumAllDiscount / 10),
                'orders_id' => $orders
            ]);
            return redirect('https://www.zarinpal.com/pg/StartPay/'.$result['Authority']);
        } else {
            echo'ERR: '.$result['Status'];
        }

    }

    public function checkPayment()
    {
        $MerchantID = '3a59d85e-f67e-11e6-b515-005056a205be'; //Required

        $Authority = $_GET['Authority'];

        $payments = Payment::where('resnumber',$_GET['Authority'])->first();

        $Amount = $payments->price; //Amount will be based on Toman





        if ($_GET['Status'] == 'OK') {
            $client = new \nusoap_client('https://www.zarinpal.com/pg/services/WebGate/wsdl', 'wsdl');
            $client->soap_defencoding = 'UTF-8';
            $result = $client->call('PaymentVerification', [
                [
                    'MerchantID'     => $MerchantID,
                    'Authority'      => $Authority,
                    'Amount'         => $Amount,
                ],
            ]);

            if ($result['Status'] == 100) {


                foreach ($payments->orders_id as $payment)
                {



                    $order = Order::where('id',$payment)->first();

                    $getSheetOpen = Sheet::where('category_id', $order->category_id)
                    ->where('status', 1)
                    ->count();

                    if ($getSheetOpen == 0)
                    {
                        // empty form not exist

                    $getSheetCount = Category::where('id', $order->category_id)->first();

                    $sheet = Sheet::create(array_merge(['category_id' => $order->category_id,
                    'user_id' => auth()->user()->id,
                    'used_unit' => 0,
                    'remining_unit' => $getSheetCount->sheet_count,
                    'status' => 1,]));

                    $sheet->used_unit += $order->unit;
                    $sheet->remining_unit -= $order->unit;
                    $sheet->save();

                    $order->sheet_id = $sheet->id;
                    $order->save();
                    }

                    else
                        {
                            // empty form exist

                            $getSheetOpen = Sheet::where('category_id', $order->category_id)
                                ->where('status', 1)
                                ->where('remining_unit', '>=', $order->unit)
                                ->orderby('remining_unit', 'asc')
                                ->first();

                            if ($getSheetOpen) {
                                $getSheetOpen->used_unit += $order->unit;
                                $getSheetOpen->remining_unit -= $order->unit;
                                $getSheetOpen->save();

                                $order->sheet_id = $getSheetOpen->id;
                                $order->save();
                            } else {
                                $getSheetCount = Category::where('id', $order->category_id)->first();

                                $sheet = Sheet::create(array_merge([
                                    'category_id' => $order->category_id,
                                    'user_id' => auth()->user()->id,
                                    'used_unit' => 0,
                                    'remining_unit' => $getSheetCount->sheet_count,
                                    'status' => 1,
                                ]));

                                $sheet->used_unit += $order->unit;
                                $sheet->remining_unit -= $order->unit;
                                $sheet->save();

                                $order->sheet_id = $sheet->id;
                                $order->save();
                            }

                        }


                    $bodyTransaction = 'شماره سفارش: ' . $order->order_number;
                    $user = User::where('id',$payments->user_id)->first();
                    $rest_balance = $user->balance;



                    if ($payments->discount) {
                        $discount = $payments->discount;
                    } else {
                        $discount = 0;
                    }

                    $deposit = 0;

                    $price = $this->calculateOrder($order);
                    $rrest_pprice = ($rest_balance - $price) + $discount;
                    $transaction = Transaction::create(
                        [
                         'order_id' => $order->id,
                         'user_id' => auth()->user()->id,
                         'client_id' => auth()->user()->id,
                         'discount' => $discount,
                         'deposit' => $deposit,
                         'body' => $bodyTransaction,
                         'rest_balance' => ($rrest_pprice),
                         'transaction_type' => 3,
                         'payment_type' => 4,
                         'price' => -($price)

                        ]); // transaction_type = 3  آنلاین سفارش

                    $user = User::where('id',$payments->user_id)->first();
                    $user->balance = $rrest_pprice;
                    $user->save();


                    $user = User::where('id',$payments->user_id)->first();
                    $rest_balance = $user->balance;

                    $price = $this->calculateOrder($order) - $discount;
                    $transaction = Transaction::create((
                        [
                            'order_id' => $order->id,
                            'user_id' => auth()->user()->id,
                            'client_id' => auth()->user()->id,
                            'discount' => $discount,
                            'deposit' => $deposit,
                            'body' => $bodyTransaction,
                            'rest_balance' => ($rest_balance + $price),
                            'transaction_type' => 3,
                            'payment_type' => 4,
                            'price' => ($price)

                       ])); // transaction_type = 3 آنلاین سفارش

                    $user = User::where('id',$payments->user_id)->first();
                    $user->balance = $rest_balance + $price;
                    $user->save();



                    Order::where('id', $payment)->update([
                        'status' => 1,
                        'status_sheets' => 1
                    ]);

                    Payment::where('resnumber',$_GET['Authority'])->update([
                        'payment' => 1
                    ]);

            }

            alert()->success('', 'پرداخت با موفقیت انجام شد');
            return redirect(route('user.allOrder'));




















            } else {
                alert()->error($result['Status'], 'مشکلی در پرداخت بوجود آمده است!');
                return redirect(route('user.allOrder'));
            }
        } else {
            alert()->error('', 'تراکنش توسط کاربر لغو شده است!');
            return redirect(route('user.allOrder'));
        }
    }

    public function increasePayment(Request $request)
    {
        $this->validate(request() , [
            'price' => 'required'
        ]);

        $price = str_replace(",","",$request->input('price')) / 10;

        $desc = 'افزایش موجودی حساب';

        $MerchantID = '3a59d85e-f67e-11e6-b515-005056a205be'; //Required

        $Description = $desc; // Required
        $Email = auth()->user()->email; // Optional
        $Mobile = auth()->user()->mobile; // Optional

        $CallbackURL = 'http://localhost:8000/user/increase-payment'; // Required

        $client = new \nusoap_client('https://www.zarinpal.com/pg/services/WebGate/wsdl', 'wsdl');
        $client->soap_defencoding = 'UTF-8';
        $result = $client->call('PaymentRequest', [
            [
                'MerchantID'     => $MerchantID,
                'Amount'         => $price,
                'Description'    => $Description,
                'Email'          => $Email,
                'Mobile'         => $Mobile,
                'CallbackURL'    => $CallbackURL,
            ],
        ]);

        //Redirect to URL You can do it also by creating a form
        if ($result['Status'] == 100) {
            Payment::create([
                'user_id' => auth()->user()->id,
                'resnumber' => $result['Authority'],
                'price' => $price,
                'discount' => 0,
                'orders_id' => 0
            ]);
            return redirect('https://www.zarinpal.com/pg/StartPay/'.$result['Authority']);
        } else {
            echo'ERR: '.$result['Status'];
        }
    }

    public function checkIncreasePayment()
    {
        $MerchantID = '3a59d85e-f67e-11e6-b515-005056a205be'; //Required

        $Authority = $_GET['Authority'];

        $payments = Payment::where('resnumber',$_GET['Authority'])->first();

        $Amount = $payments->price; //Amount will be based on Toman


        if ($_GET['Status'] == 'OK') {
            $client = new \nusoap_client('https://www.zarinpal.com/pg/services/WebGate/wsdl', 'wsdl');
            $client->soap_defencoding = 'UTF-8';
            $result = $client->call('PaymentVerification', [
                [
                    'MerchantID'     => $MerchantID,
                    'Authority'      => $Authority,
                    'Amount'         => $Amount,
                ],
            ]);

            if ($result['Status'] == 100) {

                $bodyTransaction = 'افزایش موجودی حساب';
                $user = User::where('id',auth()->user()->id)->first();
                $rest_balance = $user->balance;

                $discount = 0;

                $deposit = 0;

                $price = $Amount * 10;
                $rrest_pprice = ($rest_balance + $price);
                $transaction = Transaction::create(
                    [

                        'user_id' => auth()->user()->id,
                        'client_id' => auth()->user()->id,
                        'discount' => $discount,
                        'deposit' => $deposit,
                        'body' => $bodyTransaction,
                        'rest_balance' => $rrest_pprice,
                        'transaction_type' => 3,
                        'payment_type' => 4,
                        'price' => $price

                    ]); // transaction_type = 3  آنلاین سفارش

                $user = User::where('id',auth()->user()->id)->first();
                $user->balance = $rrest_pprice;
                $user->save();

                Payment::where('resnumber',$_GET['Authority'])->update([
                    'payment' => 1
                ]);


                alert()->success('', 'پرداخت با موفقیت انجام شد');
                return redirect(route('user.transactions'));

            } else {
                alert()->error($result['Status'], 'مشکلی در پرداخت بوجود آمده است!');
                return redirect(route('user.transactions'));
            }
        } else {
            alert()->error('', 'تراکنش توسط کاربر لغو شده است!');
            return redirect(route('user.transactions'));
        }
    }

    public function getDiscount($productId, $clientId)
    {
        $v = new Verta();

        $discount = Discount::where('status',1)->latest()->first();

        if($discount){
            if($discount->expireDate)
            {
                if($discount->expireDate >= $v->format('Y/m/d'))
                {
                    if(count($discount->client_group) > 0)
                    {
                        if(in_array($clientId, $discount->client_group))
                        {
                            return $discount->amount;
                        }
                        else
                        {
                            return 0;
                        }
                    }

                    if(count($discount->product_group) > 0)
                    {
                        if(in_array($productId, $discount->product_group))
                        {
                            return $discount->amount;
                        }
                        else
                        {
                            return 0;
                        }
                    }

                    return $discount->amount;

                }
                else
                {
                    return 0;
                }
            }
            else
            {
                if(count($discount->client_group) > 0)
                {
                    if(in_array($clientId, $discount->client_group))
                    {
                        return $discount->amount;
                    }
                    else
                    {
                        return 0;
                    }
                }

                if(count($discount->product_group) > 0)
                {
                    if(in_array($productId, $discount->product_group))
                    {
                        return $discount->amount;
                    }
                    else
                    {
                        return 0;
                    }
                }

                return $discount->amount;
            }
        }


    }

    public function pinquiries()
    {

        $pinquiries = Pinquiry::with('client','inquiry')
            ->where('client_id',auth()->user()->id)
            ->latest()->paginate(50);


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
                        $pinquiries[$key]['statusLastMess'] = '<small class="label label-info">مدیر پاسخ داده است </small>';
                    }
                }

            }
        }


        //     return $pinquiries;

        return view('User.pinquiries', compact('pinquiries'));
    }

    public function viewPinquiries()
    {
        return view('User.add_pinquiries');
    }

    public function addPinquiries(Request $request)
    {
        $this->validate(request() , [
            'title' => 'required',
            'body' => 'required'
        ]);

        $pinquiry = Pinquiry::create(array_merge($request->all(),[
            'client_id' => auth()->user()->id
        ]));

        Messinqu::create([
            'pinquiry_id' => $pinquiry->id,
            'user_id' => auth()->user()->id,
            'body' => $pinquiry->body
        ]);

        alert()->success('', 'ثبت با موفقیت انجام شد');
        return redirect(route('user.pinquiries'));

    }

    public function removePinquiries($id)
    {
        $pinquiry = Pinquiry::where('id', $id)->first();

        Messinqu::where('pinquiry_id', $id)->delete();

        $pinquiry->delete();

        alert()->success('', 'حذف با موفقیت انجام شد');
        return redirect(route('user.pinquiries'));
    }

    public function showMessinqus($id)
    {
        $messInquries = Messinqu::with(['user','pinquiry'])
            ->where('pinquiry_id', $id)
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

        return view('User.add_messinqus',compact('messInquries','title','pinqStatus'));
    }

    public function addMessinqus(Request $request)
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

        $messinqu = Messinqu::create(array_merge($request->only(
            'body',
            'pinquiry_id',
            'range',
            'length',
            'width',
            'price',
            'deposit'
        ),[
            'user_id' => auth()->user()->id,
            'images' => ($imageUrl)
        ]));


        alert()->success('','ثبت با موفقیت انجام شد');
        return redirect(route('user.showMessinqus',['id' => $request->input('pinquiry_id')]));
    }

    public function paymentPinqAccount(Request $request)
    {

        $messInquiriy = Messinqu::where('id',$request->input('messId'))->first();

        $pinquiry_id = $messInquiriy->pinquiry_id;

        $pinquiry = Pinquiry::where('id',$pinquiry_id)->first();

        $name = $pinquiry->title;

        $bodyTransaction = 'استعلام: ' . $name;

        $user = User::where('id',auth()->user()->id)->first();

        $rest_balance = $user->balance;

        $discount = 0;

        $price = $messInquiriy->price;

        $deposit = $messInquiriy->deposit;

        if($price == $deposit)
        {
            $rrest_pprice = ($rest_balance - $price);

        }else{
            $rrest_pprice = ($rest_balance - $price) + $deposit;
        }


        $transaction = Transaction::create(
            [
                'order_id' => 'pinq-'.$pinquiry_id,
                'user_id' => auth()->user()->id,
                'client_id' => auth()->user()->id,
                'discount' => $discount,
                'deposit' => $deposit,
                'body' => $bodyTransaction,
                'rest_balance' => ($rrest_pprice),
                'transaction_type' => 4,
                'payment_type' => 5,
                'price' => -($price)

            ]); // transaction_type = 4 حساب کاربری

        $user = User::where('id',auth()->user()->id)->first();
        $user->balance = $rrest_pprice;
        $user->save();

        Pinquiry::where('id',$pinquiry_id)->update([
           'status' => 1
        ]);

        alert()->success('', 'ثبت با موفقیت انجام شد');
        return redirect(route('user.pinquiries'));

    }

    public function paymentPinqOnline(Request $request)
    {

        $messInquiriy = Messinqu::where('id',$request->input('messId'))->first();

        $pinquiry_id = $messInquiriy->pinquiry_id;

        $pinquiry = Pinquiry::where('id',$pinquiry_id)->first();

        $name = $pinquiry->title;

        $deposit = $messInquiriy->deposit;

        $price = ($deposit) / 10; // Convert to Toman


        $MerchantID = '3a59d85e-f67e-11e6-b515-005056a205be'; //Required

        $desc = ': پرداخت استعلام'.$name;

        $Description = $desc; // Required
        $Email = auth()->user()->email; // Optional
        $Mobile = auth()->user()->mobile; // Optional

        $CallbackURL = 'http://localhost:8000/user/payment-pinq-online'; // Required

        $client = new \nusoap_client('https://www.zarinpal.com/pg/services/WebGate/wsdl', 'wsdl');
        $client->soap_defencoding = 'UTF-8';
        $result = $client->call('PaymentRequest', [
            [
                'MerchantID'     => $MerchantID,
                'Amount'         => $price,
                'Description'    => $Description,
                'Email'          => $Email,
                'Mobile'         => $Mobile,
                'CallbackURL'    => $CallbackURL,
            ],
        ]);

        //Redirect to URL You can do it also by creating a form
        if ($result['Status'] == 100) {
            Payment::create([
                'user_id' => auth()->user()->id,
                'resnumber' => $result['Authority'],
                'price' => $price,
                'discount' => 0,
                'orders_id' => $messInquiriy->id
            ]);
            return redirect('https://www.zarinpal.com/pg/StartPay/'.$result['Authority']);
        } else {
            echo'ERR: '.$result['Status'];
        }
    }

    public function paymentPinqOnlineCheck()
    {
        $MerchantID = '3a59d85e-f67e-11e6-b515-005056a205be'; //Required

        $Authority = $_GET['Authority'];

        $payments = Payment::where('resnumber',$_GET['Authority'])->first();

        $Amount = $payments->price; //Amount will be based on Toman


        if ($_GET['Status'] == 'OK') {
            $client = new \nusoap_client('https://www.zarinpal.com/pg/services/WebGate/wsdl', 'wsdl');
            $client->soap_defencoding = 'UTF-8';
            $result = $client->call('PaymentVerification', [
                [
                    'MerchantID'     => $MerchantID,
                    'Authority'      => $Authority,
                    'Amount'         => $Amount,
                ],
            ]);

            if ($result['Status'] == 100) {


                $messInquiriy = Messinqu::where('id',$payments->orders_id)->first();

                $pinquiry_id = $messInquiriy->pinquiry_id;

                $pinquiry = Pinquiry::where('id',$pinquiry_id)->first();

                $name = $pinquiry->title;

                $bodyTransaction = 'استعلام: ' . $name;

                $user = User::where('id',auth()->user()->id)->first();

                $rest_balance = $user->balance;

                $discount = 0;

                $price = $messInquiriy->price;

                $deposit = $messInquiriy->deposit;

                if($price == $deposit)
                {
                    $rrest_pprice = ($rest_balance - $price);

                }else{
                    $rrest_pprice = ($rest_balance - $price) + $deposit;
                }


                $transaction = Transaction::create(
                    [
                        'order_id' => 'pinq-'.$pinquiry_id,
                        'user_id' => auth()->user()->id,
                        'client_id' => auth()->user()->id,
                        'discount' => $discount,
                        'deposit' => $deposit,
                        'body' => $bodyTransaction,
                        'rest_balance' => ($rrest_pprice),
                        'transaction_type' => 3,
                        'payment_type' => 5,
                        'price' => -($price)

                    ]); // transaction_type = 3 پرداخت آنلاین

                $user = User::where('id',auth()->user()->id)->first();
                $user->balance = $rrest_pprice;
                $user->save();

                Pinquiry::where('id',$pinquiry_id)->update([
                    'status' => 1
                ]);

                Payment::where('resnumber',$_GET['Authority'])->update([
                    'payment' => 1
                ]);

                alert()->success('', 'پرداخت با موفقیت انجام شد');
                return redirect(route('user.pinquiries'));



            } else {
                alert()->error($result['Status'], 'مشکلی در پرداخت بوجود آمده است!');
                return redirect(route('user.pinquiries'));
            }
        } else {
            alert()->error('', 'تراکنش توسط کاربر لغو شده است!');
            return redirect(route('user.pinquiries'));
        }
    }

    public function allShip()
    {



        $shippings = Shipping::with(['client','order'])
            ->where('client_id', auth()->user()->id)
            ->latest()
            ->paginate(50);

        if(request('status'))
        {
            $keyword = request('status');
            if($keyword == 1)
            {
                $shippings = Shipping::with(['client','order'])
                    ->where('client_id', auth()->user()->id)
                    ->where('shipping_number','=',null)
                    ->latest()
                    ->paginate(50);
            }
            else
            {
                $shippings = Shipping::with(['client','order'])
                    ->where('client_id', auth()->user()->id)
                    ->where('shipping_number','<>','')
                    ->latest()
                    ->paginate(50);
            }

        }

        return view('User.all_ship', compact('shippings'));
    }

    public function addShip()
    {
        $orders = Order::with(['product','category'])->where('client_id', auth()->user()->id)
            ->where('status_sheets', 5)
            ->latest()
            ->paginate(50);

        foreach ($orders as $key=>$order)
        {
            $ship = Shipping::where('order_id', $order->id)->first();
            if($ship)
            {
                $orders[$key]['statusRequest'] = true;
            }
            else
            {
                $orders[$key]['statusRequest'] = false;
            }

        }

        return view('User.add_ship', compact('orders'));
    }

    public function addShipStore(Request $request)
    {
        $this->validate($request, [
            'shipping_way' => 'required',
            'shipping_name' => 'required',
            'order_id' => 'required',
        ]);

        $orders = $request->input('order_id');

        foreach ($orders as $order)
        {
            Shipping::create(array_merge($request->all(),[
                'client_id' => auth()->user()->id,
                'order_id' => $order,
            ]));
        }

        alert()->success('', 'درخواست  با موفقیت ثبت شد');
        return redirect(route('user.allShip'));

    }
}
