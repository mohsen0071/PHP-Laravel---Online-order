<?php

namespace App\Http\Controllers\Admin;

use App\ProductService;
use App\Userlog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product_services = ProductService::latest()->paginate(25);
        return view('Admin.product-services.all', compact('product_services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.product-services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request , [
            'name' => 'required',
        ]);

        ProductService::create($request->all());

        $bodyLog =   '-  ثبت خدمات محصولات     ' . $request->input('name');
        Userlog::create([
            'user_id' => auth()->user()->id,
            'body' => $bodyLog
        ]);

        alert()->success('','ثبت با موفقیت انجام شد');
        return redirect(route('product-service.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductService  $productService
     * @return \Illuminate\Http\Response
     */
    public function show(ProductService $productService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductService  $productService
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductService $productService)
    {
       // return $productService;
        return view('Admin.product-services.edit', compact('productService'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductService  $productService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductService $productService)
    {
        $this->validate($request , [
            'name' => 'required',
        ]);

        $productService->update($request->all());
        $bodyLog =   '-  ویرایش خدمات محصولات    ' . $request->input('name');
        Userlog::create([
            'user_id' => auth()->user()->id,
            'body' => $bodyLog
        ]);
        alert()->success('','ویرایش با موفقیت انجام شد');
        return redirect(route('product-service.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductService  $productService
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductService $productService)
    {
        $bodyLog =  '- حذف خدمات محصولات    '. $productService->name;
        Userlog::create([
            'user_id' => auth()->user()->id,
            'body' => $bodyLog
        ]);

        $productService->delete();
        alert()->success('','حذف با موفقیت انجام شد');
        return redirect(route('product-service.index'));
    }
}
