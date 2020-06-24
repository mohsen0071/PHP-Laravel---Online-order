<?php

namespace App\Http\Controllers;

use App\Pservice;
use App\User;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Intervention\Image\Facades\Image;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function uploadFileInquiry($file)
    {

        $imagePath = "/upload/inquiry/";
        $filename = time().($file->getClientOriginalName());

        $file = $file->move(public_path($imagePath) , $filename);

        $url = $imagePath.$file->getFilename();
        return $url;
    }

    protected function uploadImages($file,$path)
    {
        $year = Carbon::now()->year;
        $imagePath = "/upload/{$path}/{$year}/";
        $filename = $file->getClientOriginalName();

        $file = $file->move(public_path($imagePath) , $filename);

        $sizes = ["200"];
        $url['images'] = $this->resize($file->getRealPath() , $sizes , $imagePath , $filename);
        $url['thumb'] = $url['images'][$sizes[0]];

        return $url;
    }

    protected function uploadImagesUser($file,$path)
    {
        $year = Carbon::now()->year;
        $imagePath = "/upload/{$path}/{$year}/";
        $filename = $file->getClientOriginalName();

        $file = $file->move(public_path($imagePath) , $filename);

        $sizes = ["200"];
        $url['images'] = $this->resize($file->getRealPath() , $sizes , $imagePath , $filename);
        $url['thumb'] = $url['images'][$sizes[0]];

        return $url['thumb'];
    }

    private function resize($path , $sizes , $imagePath , $filename)
    {
        $images['original'] = $imagePath . $filename;
        foreach ($sizes as $size) {
            $images[$size] = $imagePath . "{$size}-" . $filename;

            Image::make($path)->resize($size, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path($images[$size]));

        }

        return $images;
    }

    private function resizeOrder($path , $sizes , $imagePath , $filename)
    {
        $images['original'] = $imagePath . $filename;
        foreach ($sizes as $size) {
            $images[$size] = $imagePath . "{$size}-" . $filename;

            Image::make($path)->resize($size, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path($images[$size]));

        }

        $blah = getimagesize($path);
//        if($blah['channels']==4){
//            // it is cmyk
//        }
//
        $dpiPath = $this->get_dpi($path);
        $images['dpi']['x'] = $dpiPath[0];
        $images['dpi']['y'] = $dpiPath[1];
        $images['dpi']['cmyk'] = $blah['channels'];

        return $images;
    }

    protected function uploadOrderImages($file, $clientName)
    {
        $v = new Verta();
        $directoryName =  $v->format('Y-n-j');

        $imagePath = "/upload/order/{$directoryName}/";
        $filename = $clientName.($file->getClientOriginalName());

        $file = $file->move(public_path($imagePath) , $filename);

        $sizes = ["100"];
        $url = $this->resizeOrder($file->getRealPath() , $sizes , $imagePath , $filename);

        return $url;
    }

    protected function get_dpi($filename){
        $a = fopen($filename,'r');
        $string = fread($a,20);
        fclose($a);

        $data = bin2hex(substr($string,14,4));
        $x = substr($data,0,4);
        $y = substr($data,4,4);

        return array(hexdec($x),hexdec($y));
    }

    public function orderNumber($number)
    {
        if(strlen($number) == 1)
        {
            $number = '00000'.$number;
        }
        elseif(strlen($number) == 2)
        {
            $number = '0000'.$number;
        }
        elseif(strlen($number) == 3)
        {
            $number = '000'.$number;
        }
        elseif(strlen($number) == 4)
        {
            $number = '00'.$number;
        }
        elseif(strlen($number) == 5)
        {
            $number = '0'.$number;
        }
        elseif(strlen($number) == 6)
        {
            $number = $number;
        }
        else
        {

        }

        return $number;
    }

    protected function  calculateOrder($order)
    {
        $allPservicePrice = 0;
        if($order->pservices){
            foreach (json_decode($order->pservices) as $pservice)
            {
                $pserviceTitle = Pservice::find($pservice);
                $allPservicePrice += $pserviceTitle->pservice_price;
            }
        }

        if($order->urgent == 1)
        {
            $orderPrice = $order->product->urgent_price;
        }
        else
        {
            $orderPrice = $order->product->price;
        }

        $userType = User::where('id',$order->client_id)->first();

        if($userType->user_type == 2)
        {
            if($order->product->partner_price != Null)
            {
                $orderPrice = $order->product->partner_price;
            }
            if($order->urgent == 1 && $order->product->partner_urgent_price != Null)
            {
                $orderPrice = $order->product->partner_urgent_price;
            }
        }

        $pservicePrice = ($order->range / 1000) * $order->category->pservice_unit * $allPservicePrice;
        $productPrice =  $order->unit * $orderPrice * ($order->range / 1000);

        return $productPrice + $pservicePrice + $order->price_design;
    }

    protected  function  shamsiToMiladi($date)
    {
        $resultDate = Verta::getGregorian(substr($date,0,4),substr($date,5,2),substr($date,8,2));

        $year = $resultDate[0];

        if(strlen($resultDate[1]) == 1)
        {
            $month = '0'.$resultDate[1];
        }
        else
        {
            $month = $resultDate[1];
        }

        if(strlen($resultDate[2]) == 1)
        {
            $day = '0'.$resultDate[2];
        }
        else
        {
            $day = $resultDate[2];
        }

        return $year.'-'.$month.'-'.$day;
    }


}
