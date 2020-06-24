<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use App\Pservice;
use App\User;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
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
        $directoryName =  $v->format('Y-m-d');

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

    public function getFirstOrderInSheet($sheetId)
    {
        $order = Order::where('sheet_id',$sheetId)
            ->orderby('created_at','asc')
            ->first();
        if($order){
            return $order->created_at;
        }
        return null;
    }

    public function convertNumberToWords($input) {

            $words = [
                [
                    "",
                    "یک",
                    "دو",
                    "سه",
                    "چهار",
                    "پنج",
                    "شش",
                    "هفت",
                    "هشت",
                    "نه"
                ],
                [
                    "ده",
                    "یازده",
                    "دوازده",
                    "سیزده",
                    "چهارده",
                    "پانزده",
                    "شانزده",
                    "هفده",
                    "هجده",
                    "نوزده",
                    "بیست"
                ],
                [
                    "",
                    "",
                    "بیست",
                    "سی",
                    "چهل",
                    "پنجاه",
                    "شصت",
                    "هفتاد",
                    "هشتاد",
                    "نود"
                ],
                [
                    "",
                    "یکصد",
                    "دویست",
                    "سیصد",
                    "چهارصد",
                    "پانصد",
                    "ششصد",
                    "هفتصد",
                    "هشتصد",
                    "نهصد"
                ],
                [
                    '',
                    " هزار ",
                    " میلیون ",
                    " میلیارد ",
                    " بیلیون ",
                    " بیلیارد ",
                    " تریلیون ",
                    " تریلیارد ",
                    " کوآدریلیون ",
                    " کادریلیارد ",
                    " کوینتیلیون ",
                    " کوانتینیارد ",
                    " سکستیلیون ",
                    " سکستیلیارد ",
                    " سپتیلیون ",
                    " سپتیلیارد ",
                    " اکتیلیون ",
                    " اکتیلیارد ",
                    " نانیلیون ",
                    " نانیلیارد ",
                    " دسیلیون "
                ]
            ];
            $splitter = " و ";

            $zero = "صفر";
            if ($input == 0) {
                return $zero;
            }
            if (strlen($input) > 66) {
                return "خارج از محدوده";
            }
            //Split to sections
            $splittedNumber = $this->prepareNumber($input);
            $result = [];
            $splitLength = count($splittedNumber);
            for ($i = 0; $i < $splitLength; $i++) {
                $sectionTitle = $words[4][$splitLength - ($i + 1)];
                $converted    = $this->threeNumbersToLetter($splittedNumber[$i]);
                if ($converted !== "") {
                    array_push($result, $converted . $sectionTitle);
                }
            }

            return join($splitter, $result);
    }

    public function prepareNumber($num) {
        if (gettype($num) == "integer" || gettype($num) == "double") {
            $num = (string) $num;
        }
        $length = strlen($num) % 3;
        if ($length == 1) {
            $num = "00" . $num;
        } else if ($length == 2) {
            $num = "0" . $num;
        }
        return str_split($num, 3);
    }

    public function threeNumbersToLetter($num) {
        global $words, $splitter;
        if ((int) preg_replace('/\D/', '', $num) == 0) {
            return "";
        }
        $parsedInt = (int) preg_replace('/\D/', '', $num);
        if ($parsedInt < 10) {
            return $words[0][$parsedInt];
        }
        if ($parsedInt <= 20) {
            return $words[1][$parsedInt - 10];
        }
        if ($parsedInt < 100) {
            $one = $parsedInt % 10;
            $ten = ($parsedInt - $one) / 10;
            if ($one > 0) {
                return $words[2][$ten] . $splitter . $words[0][$one];
            }
            return $words[2][$ten];
        }
        $one        = $parsedInt % 10;
        $hundreds   = ($parsedInt - $parsedInt % 100) / 100;
        $ten        = ($parsedInt - (($hundreds * 100) + $one)) / 10;
        $out        = [$words[3][$hundreds]];
        $secondPart = (( $ten * 10 ) + $one);
        if ($secondPart > 0) {
            if ($secondPart < 10) {
                array_push($out, $words[0][$secondPart]);
            } else if ($secondPart <= 20) {
                array_push($out, $words[1][$secondPart - 10]);
            } else {
                array_push($out, $words[2][$ten]);
                if ($one > 0) {
                    array_push($out, $words[0][$one]);
                }
            }
        }
        return join($splitter, $out);
    }

    public function digit_to_persain_letters($money)
    {
        $one = array(
            'صفر',
            'یک',
            'دو',
            'سه',
            'چهار',
            'پنج',
            'شش',
            'هفت',
            'هشت',
            'نه');
        $ten = array(
            '',
            'ده',
            'بیست',
            'سی',
            'چهل',
            'پنجاه',
            'شصت',
            'هفتاد',
            'هشتاد',
            'نود',
        );
        $hundred = array(
            '',
            'یکصد',
            'دویست',
            'سیصد',
            'چهارصد',
            'پانصد',
            'ششصد',
            'هفتصد',
            'هشتصد',
            'نهصد',
        );
        $categories = array(
            '',
            'هزار',
            'میلیون',
            'میلیارد',
        );
        $exceptions = array(
            '',
            'یازده',
            'دوازده',
            'سیزده',
            'چهارده',
            'پانزده',
            'شانزده',
            'هفده',
            'هجده',
            'نوزده',
        );

//        if(strlen($money) > count($categories)){
//            throw new Exception('number is longger!');
//        }

        $letters_separator = ' و ';
        $money = (string)(int)$money;
        $money_len = strlen($money);
        $persian_letters = '';

        for($i=$money_len-1; $i>=0; $i-=3){
            $i_one = (int)isset($money[$i]) ? $money[$i] : -1;
            $i_ten = (int)isset($money[$i-1]) ? $money[$i-1] : -1;
            $i_hundred = (int)isset($money[$i-2]) ? $money[$i-2] : -1;

            $isset_one = false;
            $isset_ten = false;
            $isset_hundred = false;

            $letters = '';

            // zero
            if($i_one == 0 && $i_ten < 0 && $i_hundred < 0){
                $letters = $one[$i_one];
            }

            // one
            if(($i >= 0) && $i_one > 0 && $i_ten != 1 && isset($one[$i_one])){
                $letters = $one[$i_one];
                $isset_one = true;
            }

            // ten
            if(($i-1 >= 0) && $i_ten > 0 && isset($ten[$i_ten])){
                if($isset_one){
                    $letters = $letters_separator.$letters;
                }

                if($i_one == 0){
                    $letters = $ten[$i_ten];
                }
                elseif($i_ten == 1 && $i_one > 0){
                    $letters = $exceptions[$i_one];
                }
                else{
                    $letters = $ten[$i_ten].$letters;
                }

                $isset_ten = true;
            }

            // hundred
            if(($i-2 >= 0) && $i_hundred > 0 && isset($hundred[$i_hundred])){
                if($isset_ten || $isset_one){
                    $letters = $letters_separator.$letters;
                }

                $letters = $hundred[$i_hundred].$letters;
                $isset_hundred = true;
            }

            if($i_one < 1 && $i_ten < 1 && $i_hundred < 1){
                $letters = '';
            }
            else{
                $letters .= ' '.$categories[($money_len-$i-1)/3];
            }

            if(!empty($letters) && $i >= 3){
                $letters = $letters_separator.$letters;
            }

            $persian_letters = $letters.$persian_letters;
        }

        return $persian_letters;
    }
}
