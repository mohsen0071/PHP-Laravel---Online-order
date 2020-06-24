<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Order;
use App\Sheet;
use App\Userlog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use ZipArchive;


class SheetController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request('category_id') && request('status'))
        {
            $category_id = request('category_id');
            $status = request('status');
            $sheets = Sheet::with(['category','user'])->where('category_id',$category_id)->where('status',$status)->orderBy('status','ASC')->paginate(25);
            $categories = Category::getTree();
        }
        else if(request('category_id'))
        {
            $category_id = request('category_id');
            $sheets = Sheet::with(['category','user'])->where('category_id',$category_id)->orderBy('status','ASC')->paginate(25);
            $categories = Category::getTree();
        }
        else if(request('status'))
        {
            $status = request('status');
            $sheets = Sheet::with(['category','user'])->where('status',$status)->orderBy('status','ASC')->paginate(25);
            $categories = Category::getTree();
        }
        else
        {
            $sheets = Sheet::with(['category','user'])->orderBy('status','ASC')->paginate(25);
            $categories = Category::getTree();
        }

        foreach ($sheets as $key => $sheet)
        {
            $sheets[$key]['firstOrderDate'] =  $this->getFirstOrderInSheet($sheet->id);
        }

     //   return $sheets;

        return view('Admin.sheets.all', compact('sheets','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::getTree();
        return view('Admin.sheets.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Sheet $sheet)
    {
        $this->validate($request , [
            'category_id' => 'required',
            'remining_unit' => 'required|numeric',
        ]);

        $inputs = $request->all();

        $sheet->create([
            'category_id' => $inputs['category_id'],
            'user_id' => auth()->user()->id,
            'used_unit' => 0,
            'remining_unit' => $inputs['remining_unit'],
            'status' => $inputs['status'],
            'body' => $inputs['body'],
        ]);

        $bodyLog =  ' ثبت شیت    ';
        Userlog::create([
            'user_id' => auth()->user()->id,
            'body' => $bodyLog
        ]);

        alert()->success('','ثبت با موفقیت انجام شد');
        return redirect(route('sheets.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sheet  $sheet
     * @return \Illuminate\Http\Response
     */
    public function show(Sheet $sheet)
    {
        $orders = Order::with(['client','category'])
            ->where('sheet_id',$sheet->id)
            ->latest()
            ->paginate(50);
        $sheet = Sheet::where('id',$sheet->id)->first();

        return view('Admin.sheets.show',compact('orders','sheet'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sheet  $sheet
     * @return \Illuminate\Http\Response
     */
    public function edit(Sheet $sheet)
    {
        $categories = Category::getTree();
        return view('Admin.sheets.edit', compact('categories','sheet'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sheet  $sheet
     * @return \Illuminate\Http\Response
     */


    public function SendREST($username,$password, $Source, $Destination, $MsgBody, $Encoding)
    {

        $URL = "http://panel.asanak.ir/webservice/v1rest/sendsms";
        $msg = urlencode(trim($MsgBody));
        $url = $URL.'?username='.$username.'&password='.$password.'&source='.$Source.'&destination='.$Destination.'&message='. $msg;
        $headers[] = 'Accept: text/html';
        $headers[] = 'Connection: Keep-Alive';
        $headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
        $process = curl_init($url);
        curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($process, CURLOPT_HEADER, 0);
        curl_setopt($process, CURLOPT_TIMEOUT, 30);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
        try
        {
            if(($return = curl_exec($process)))
            {
                return $return;
            }
        } catch (Exception $ex)
        {
            return $ex->errorMessage();
        }
    }

    public function update(Request $request, Sheet $sheet)
    {
        $this->validate($request , [
            'category_id' => 'required',
            'remining_unit' => 'required|numeric',
        ]);

        $inputs = $request->all();


        $sheet->where('id', $sheet->id )->update([
            'category_id' => $inputs['category_id'],
            'user_id' => auth()->user()->id,
            'used_unit' => $inputs['used_unit'],
            'remining_unit' => $inputs['remining_unit'],
            'status' => $inputs['status'],
            'body' => $inputs['body'],
        ]);

        Order::where('sheet_id',$sheet->id)->update([
            'status_sheets' => $inputs['status']
        ]);

        if($inputs['status'] == 5)
        {
            $orders = Order::with(['client'])->where('sheet_id',$sheet->id)->get();
            foreach ($orders as $order)
            {
                $message = " با سلام،مشتری گرامی سفارش "
                    .$order->name
                    ." به شماره "
                    .$order->order_number
                    ." آماده تحویل می باشد. ";
                $mobile = $order->client->mobile;
                $encoding = (mb_detect_encoding($message) == 'ASCII') ? "1" : "8";
                $this->SendREST('mahdikazemi1364','Mahan@1395', '982133119674', $mobile, $message, $encoding);
            }
        }

        $bodyLog =  ' ویرایش شیت    ' . $sheet->id;
        Userlog::create([
            'user_id' => auth()->user()->id,
            'body' => $bodyLog
        ]);


        alert()->success('','ویرایش با موفقیت انجام شد');
        return redirect(route('sheets.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sheet  $sheet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sheet $sheet)
    {
        if($sheet->used_unit > 0)
        {
            alert()->error('','حذف امکان پذیر نیست');
        }
        else
        {
            $sheet->delete();
            alert()->success('','حذف با موفقیت انجام شد');
        }

        $bodyLog =  ' حذف شیت    ' . $sheet->id;
        Userlog::create([
            'user_id' => auth()->user()->id,
            'body' => $bodyLog
        ]);

        return redirect(route('sheets.index'));
    }

    public function move()
    {
        $categories = Category::getTree();
        return view('Admin.sheets.move', compact('categories'));
    }

    public function getSheet(Request $request, $sheet)
    {
        if (!$request->ajax()) {
            throw new MethodNotAllowedException(['ajax']);
        }

//        $cities = City::where('province_id', $provinceId)
//            ->orderBy('id', 'ASC')
//            ->pluck('name', 'id')
//            ->toArray();

        return response($sheet);
    }


    public function sheetZip(Request $request)
    {
        if(request('order_id'))
        {
            $zip = new ZipArchive();            // Load zip library
            $zip_name = request('zipFileName').".zip";
            if($zip->open($zip_name, ZIPARCHIVE::CREATE)!==TRUE){       // Opening zip file to load files
               exit('Sorry ZIP creation failed at this time');
            }

            $files = request('order_id');
            foreach ($files as $file)
            {
                $destinationName =  basename($file);
                $file = substr($file, 1);
                $zip->addFile($file,$destinationName);
            }
            $zip->close();

            if(file_exists($zip_name)){
                // push to download the zip
                header('Content-type: application/zip');
                header('Content-Disposition: attachment; filename="'.$zip_name.'"');
                readfile($zip_name);
                // remove zip file is exists in temp path
                unlink($zip_name);
            }


        }
        else
        {
            alert()->error('','فایلی برای دانلود انتخاب نشده است');
            return back();
        }

    }
}
