<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Order;
use App\Sheet;
use App\Transaction;
use App\User;
use App\Userlog;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request('transaction_type') != '' && request('client_id') != '')
        {
        $dateFrom = request('date_from');
            $dateTo = request('date_to');

            $dateFrom = $this->shamsiToMiladi($dateFrom).' 00:00:00';
            $dateTo = $this->shamsiToMiladi($dateTo).' 23:59:59';

            $transactions = Transaction::with(['user','client','order'])
                ->where('created_at','>=', $dateFrom)
                ->where('created_at','<=', $dateTo)
                ->where('client_id',request('client_id'))
                ->where('transaction_type',request('transaction_type'))
                ->orderby('id','desc')
                ->paginate(50);
        }
        elseif (request('client_id') != '')
        {
            $dateFrom = request('date_from');
            $dateTo = request('date_to');

            $dateFrom = $this->shamsiToMiladi($dateFrom).' 00:00:00';
            $dateTo = $this->shamsiToMiladi($dateTo).' 23:59:59';

            $transactions = Transaction::with(['user','client','order'])
                ->where('created_at','>=', $dateFrom)
                ->where('created_at','<=', $dateTo)
                ->where('client_id',request('client_id'))
                ->orderby('id','desc')
                ->paginate(50);
        }
        elseif(request('transaction_type') != '')
        {
            $dateFrom = request('date_from');
            $dateTo = request('date_to');

            $dateFrom = $this->shamsiToMiladi($dateFrom).' 00:00:00';
            $dateTo = $this->shamsiToMiladi($dateTo).' 23:59:59';

            $transactions = Transaction::with(['user','client','order'])
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
                ->where('created_at','>=', $dateFrom)
                ->where('created_at','<=', $dateTo)
                ->orderby('id','desc')
                ->paginate(50);


        }
        else
        {
            $transactions = Transaction::with(['user','client','order'])->orderby('id','desc')->paginate(50);

        }

        $sumall = 0;

        if($transactions && request('date_from'))
        {
            foreach ($transactions as $transaction) {
                $discount = str_replace(",", "", $transaction->discount);
                $deposit = str_replace(",", "", $transaction->deposit);
                $sumall += ($transaction->price) + ($discount) + ($deposit);
            }
        }

        $users = User::select('id','name','mobile')->where('level','user')->get();
        return view('Admin.transactions.all',compact('transactions','users','sumall'));
    }

    public function transactionsCheques()
    {
        if(request('payment_way') != '' && request('client_id') != '')
        {
            $dateFrom = request('date_from');
            $dateTo = request('date_to');

            $dateFrom = $this->shamsiToMiladi($dateFrom).' 00:00:00';
            $dateTo = $this->shamsiToMiladi($dateTo).' 23:59:59';

            $transactions = Transaction::with(['user','client','order'])
                ->where('created_at','>=', $dateFrom)
                ->where('created_at','<=', $dateTo)
                ->where('client_id',request('client_id'))
                ->where('payment_way',request('payment_way'))
                ->where('payment_type',2)
                ->orderby('id','desc')
                ->paginate(50);
        }
        elseif (request('client_id') != '')
        {
            $dateFrom = request('date_from');
            $dateTo = request('date_to');

            $dateFrom = $this->shamsiToMiladi($dateFrom).' 00:00:00';
            $dateTo = $this->shamsiToMiladi($dateTo).' 23:59:59';

            $transactions = Transaction::with(['user','client','order'])
                ->where('created_at','>=', $dateFrom)
                ->where('created_at','<=', $dateTo)
                ->where('client_id',request('client_id'))
                ->where('payment_type',2)
                ->orderby('id','desc')
                ->paginate(50);
        }
        elseif(request('payment_way') != '')
        {
            $dateFrom = request('date_from');
            $dateTo = request('date_to');

            $dateFrom = $this->shamsiToMiladi($dateFrom).' 00:00:00';
            $dateTo = $this->shamsiToMiladi($dateTo).' 23:59:59';

            $transactions = Transaction::with(['user','client','order'])
                ->where('created_at','>=', $dateFrom)
                ->where('created_at','<=', $dateTo)
                ->where('payment_way',request('payment_way'))
                ->where('payment_type',2)
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
                ->where('created_at','>=', $dateFrom)
                ->where('created_at','<=', $dateTo)
                ->where('payment_type',2)
                ->orderby('id','desc')
                ->paginate(50);


        }
        else
        {
            $transactions = Transaction::with(['user','client','order'])
                ->where('payment_type',2)
                ->orderby('id','desc')->paginate(50);

        }

        $sumall = 0;

        foreach ($transactions as $transaction)
        {
            $sumall += $transaction->price;
        }

        $users = User::select('id','name','mobile')->where('level','user')->get();

        return view('Admin.transactions.all_cheque',compact('transactions','users','sumall'));
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
            'user_id' => 'required',
            'order_id' => 'required',
            'payment_type' => 'required',
            'price' => 'required',
        ]);

        $order = Order::find($request->input('order_id'));

        $getSheetOpen = Sheet::where('category_id',$order->category_id)
            ->where('status',1)
            ->count();

        if($getSheetOpen == 0)
        {
           // empty form not exist

            $getSheetCount = Category::where('id',$order->category_id)->first();

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
        else
        {
            // empty form exist

            $getSheetOpen = Sheet::where('category_id',$order->category_id)
                ->where('status',1)
                ->where('remining_unit','>=',$order->unit)
                ->orderby('remining_unit', 'asc')
                ->first();

                if($getSheetOpen)
                {
                    $getSheetOpen->used_unit += $order->unit;
                    $getSheetOpen->remining_unit -= $order->unit;
                    $getSheetOpen->save();

                    $order->sheet_id = $getSheetOpen->id;
                    $order->save();
                }
                else
                {
                    $getSheetCount = Category::where('id',$order->category_id)->first();

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



        $bodyTransaction = 'شماره سفارش: '.$order->order_number.'<br/>'.$request->input('body');
        $user = User::find( $request->input('client_id') );
        $rest_balance = $user->balance;

        if($request->input('payment_type') == 3)
        {

            if($request->input('discount'))
            {
                $discount = str_replace(",","",$request->input('discount'));
            }
            else
            {
                $discount = 0;
            }

            if($request->input('deposit'))
            {
                $deposit = str_replace(",","",$request->input('deposit'));
            }
            else
            {
                $deposit = 0;
            }

            $price = $this->calculateOrder($order) - ($discount + $deposit);

            $transaction = Transaction::create(array_merge($request->all(),['discount'=>$discount,'deposit'=>$deposit,'body'=>$bodyTransaction,'rest_balance'=>($rest_balance - $price),'transaction_type' => 1,'price' => -($this->calculateOrder($order))])); // transaction_type = 1 سفارش
            $user = User::find( $request->input('client_id') );
            $user->balance -= $price;
            $user->save();
        }
        else
        {
            // نقدی یا کارت به کارت
            $user = User::find( $request->input('client_id') );
            $rest_balance = $user->balance;

            if($request->input('discount'))
            {
                $discount = str_replace(",","",$request->input('discount'));
            }
            else
            {
                $discount = 0;
            }

            if($request->input('deposit'))
            {
                $deposit = str_replace(",","",$request->input('deposit'));
            }
            else
            {
                $deposit = 0;
            }

            $price = $this->calculateOrder($order);
            $rrest_pprice = ($rest_balance - $price) + $discount;
            $transaction = Transaction::create(array_merge($request->all(),['discount'=>$discount,'deposit'=>$deposit,'body'=>$bodyTransaction,'rest_balance'=>($rrest_pprice),'transaction_type' => 1,'price' => -($price) ])); // transaction_type = 1 سفارش
            $user = User::find( $request->input('client_id') );
            $user->balance = $rrest_pprice;
            $user->save();


            $user = User::find( $request->input('client_id') );
            $rest_balance = $user->balance;

            $price = $this->calculateOrder($order) - $discount;
            $transaction = Transaction::create(array_merge($request->all(),['discount'=>$discount,'deposit'=>$deposit,'rest_balance'=>($rest_balance + $price),'transaction_type' => 2, 'price' => $price, 'discount'=> 0])); // transaction_type = 2 ثبت مدیر
            $user = User::find( $request->input('client_id') );
            $user->balance = $rest_balance + $price;
            $user->save();
        }

        Order::where('id', $request->input('order_id'))->update([
            'status' => 1,
            'status_sheets' => 1,
        ]);

        $bodyLog =  '  ثبت تراکنش ' . $bodyTransaction;
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
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }

    public function client_transaction($client_id)
    {

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
        return view('Admin.transactions.client_transaction',compact('transactions','client','sumall'));
    }

    public function client_cheques($client_id)
    {


        if(request('date_from') && request('payment_way'))
        {
            $dateFrom = request('date_from');
            $dateTo = request('date_to');

            $dateFrom = $this->shamsiToMiladi($dateFrom).' 00:00:00';
            $dateTo = $this->shamsiToMiladi($dateTo).' 23:59:59';

            $transactions = Transaction::with(['user','client','order'])
                ->where('client_id',$client_id)
                ->where('payment_type',2)
                ->where('created_at','>=', $dateFrom)
                ->where('created_at','<=', $dateTo)
                ->where('payment_way',request('payment_way'))
                ->orderby('id','desc')
                ->paginate(50);

        }
        elseif(request('date_from'))
        {
            $dateFrom = request('date_from');
            $dateTo = request('date_to');

            $dateFrom = $this->shamsiToMiladi($dateFrom).' 00:00:00';
            $dateTo = $this->shamsiToMiladi($dateTo).' 23:59:59';
          //  return $dateTo;
            $transactions = Transaction::with(['user','client','order'])
                ->where('client_id',$client_id)
                ->where('created_at','>=', $dateFrom)
                ->where('created_at','<=', $dateTo)
                ->where('payment_type',2)
                ->orderby('id','desc')
                ->paginate(50);


        }
        else
        {
            $transactions = Transaction::with(['user','client','order'])
                ->where('client_id',$client_id)
                ->where('payment_type',2)
                ->orderby('id','desc')
                ->paginate(50);

        }
        $sumall = 0;

        foreach ($transactions as $transaction)
        {
            $sumall += $transaction->price;
        }

        $client = User::find($client_id);
        return view('Admin.transactions.client_cheques',compact('transactions','client','sumall'));
    }

    public function transactionRecievePay()
    {
        $users = User::with(['city'])->where('level','user')->get();
        return view('Admin.transactions.recieve_pay',compact('users'));
    }

    public function storeRecievePay(Request $request)
    {
        $this->validate($request, [
            'client_id' => 'required',
            'payment_type' => 'required',
            'price' => 'required',
            'recieve_pay_type' => 'required',
        ]);

        $user = User::find( $request->input('client_id') );
        $rest_balance = $user->balance;

        $price = str_replace(",","",$request->input('price'));

        // دریافتی

        if($request->input('recieve_pay_type') == 1)
        {
            $bodyTransaction = ' دریافتی مدیر '.'<br/>'.$request->input('body');
            $transaction = Transaction::create(array_merge($request->only(
                'client_id',
                'user_id',
                'payment_type',
                'bank_type',
                'payment_way',
                'pay_date',
                'proof_number'
            ),[
                'body'=> $bodyTransaction,
                'rest_balance'=>($rest_balance + $price),
                'transaction_type' => 2,
                'price' => $price])); // transaction_type =  2  پرداختی مدیر

            $user = User::find( $request->input('client_id') );
            $user->balance = $rest_balance + $price;
            $user->save();
        }
        else
        {
            $bodyTransaction = ' پرداختی مدیر '.'<br/>'.$request->input('body');
            $transaction = Transaction::create(array_merge($request->only(
                'client_id',
                'user_id',
                'payment_type',
                'bank_type',
                'payment_way',
                'pay_date',
                'proof_number'
            ),[
                'body'=> $bodyTransaction,
                'rest_balance'=>($rest_balance - $price),
                'transaction_type' => 2,
                'price' => -($price)])); // transaction_type = 2  پرداختی مدیر

            $user = User::find( $request->input('client_id') );
            $user->balance = $rest_balance - $price;
            $user->save();
        }

        $bodyLog =   ' دریافتی پرداختی ' . $bodyTransaction;
        Userlog::create([
            'user_id' => auth()->user()->id,
            'body' => $bodyLog
        ]);
        return redirect(route('transactions.index'));

    }
}
