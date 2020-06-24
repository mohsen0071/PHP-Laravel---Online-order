<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class PanelController extends AdminController
{
    public function index()
    {
        $startDate = Carbon::now()->toDateString().' 00:00:00';
        $endDate = Carbon::now()->toDateString().' 23:59:59';
        $count_client = User::where('level','user')->count();
        $count_employee = User::where('level','admin')->count();
        $count_order = Order::where('created_at' , '>' , $startDate)
            ->where('created_at' , '<' , $endDate)
            ->count();

        $price_all_order = Order::where('created_at' , '>' , $startDate)
            ->where('created_at' , '<' , $endDate)
            ->get();
        $final_day_price = 0;
        foreach ($price_all_order as $order)
        {
            $final_day_price += $this->calculateOrder($order);
        }

        $orders = Order::with(['category','user','product','client'])
            ->latest()
            ->paginate(10);

        return view('Admin.panel', compact('count_client','count_employee','count_order','final_day_price','orders'));
    }

    public function uploadImageSubject()
    {
        $this->validate(request() , [
            'upload' => 'required|mimes:jpeg,png,bmp',
        ]);

        $year = Carbon::now()->year;
        $imagePath = "/upload/images/{$year}/";

        $file = request()->file('upload');
        $filename = $file->getClientOriginalName();

        if(file_exists(public_path($imagePath) . $filename)) {
            $filename = Carbon::now()->timestamp . $filename;
        }

        $file->move(public_path($imagePath) , $filename);
        $url = $imagePath . $filename;

        return "<script>window.parent.CKEDITOR.tools.callFunction(1 , '{$url}' , '')</script>";
    }

}
