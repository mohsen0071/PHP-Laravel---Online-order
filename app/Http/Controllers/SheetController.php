<?php
namespace App\Http\Controllers;

use App\Order;
use App\Sheet;
use App\Userlog;
use Illuminate\Http\Request;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

class SheetController extends Controller
{

    public function index(Request $request, $categoryId)
    {
        if (!$request->ajax()) {
            throw new MethodNotAllowedException(['ajax']);
        }

        $sheets = Sheet::where('status', '1')
            ->where('remining_unit', '>', 0)
            ->where('category_id',$categoryId)
            ->orderBy('remining_unit', 'ASC')
            ->pluck('remining_unit', 'id')
            ->toArray();

        return response($sheets);
    }

    public function files(Request $request, $sheetId)
    {
        if (!$request->ajax()) {
            throw new MethodNotAllowedException(['ajax']);
        }

        $products = Order::with(['client','sheet'])
            ->where('sheet_id', $sheetId)
            ->orderBy('unit', 'ASC')
            ->get()
            ->toArray();



        return response($products);
    }

    public function move(Request $request)
    {
        $startTableSheetId = $request->input('startTableSheetId');
        $endTableSheetId = $request->input('endTableSheetId');
        $selectedFiles = $request->input('selectedFiles');

        $result = 0;

        if(count($selectedFiles) > 0)
        {
            for ($i=0; $i<count($selectedFiles); $i++)
            {
                $sheet = Sheet::where('id',$endTableSheetId)->first();
                $sheetStart = Sheet::where('id',$startTableSheetId)->first();

                $sheetRemining = $sheet->remining_unit;

                $getSingleOrder = Order::where('id',$selectedFiles[$i])->first();
                $unit = $getSingleOrder->unit;

                if($sheetRemining >= $unit)
                {
                    Order::where('id',$selectedFiles[$i])->update([
                       'sheet_id' =>  $endTableSheetId
                    ]);

                    $sheet->used_unit += $unit;
                    $sheet->remining_unit -= $unit;
                    $sheet->save();

                    $sheetStart->used_unit -= $unit;
                    $sheetStart->remining_unit += $unit;
                    $sheetStart->save();

                    $result = 1;
                }else{
                    $result = 0;
                }

            }
        }

        $bodyLog =  ' جابجایی بین شیت    ' . $startTableSheetId;
        Userlog::create([
            'user_id' => auth()->user()->id,
            'body' => $bodyLog
        ]);

        return response($result);
    }

}
