<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use App\Pservice;
use App\Setting;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PrintController extends AdminController
{

    public function order($id)
    {
        $setting = Setting::latest()->first();

        $orders = Order::with(['category','user','product'])->where('id',$id)->first();
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

        $transaction = Transaction::where('order_id',$id)
            ->where('transaction_type',1)->first();
        if($transaction)
        {
            if($transaction->discount != '')
            {
                $discount = $transaction->discount;
            }
            else
            {
                $discount = 0;
            }

            if($transaction->deposit != '')
            {
                $deposit = $transaction->deposit;
            }
            else
            {
                $deposit = 0;
            }
        }
        else
        {
            $discount = 0;
            $deposit = 0;
        }



        $pservicePrice = ($orders->range / 1000) * $orders->category->pservice_unit * $allPservicePrice;
        $productPrice =  $this->calculateOrder($orders);
        $letterPrice = $this->digit_to_persain_letters($productPrice - $discount -  $deposit);



        return view('Admin.prints.order',
            compact('orders','client','allPservice','allPservicePrice'
                ,'pservicePrice','productPrice','letterPrice','setting','orderPrice','deposit','discount')
        );


    }
}
