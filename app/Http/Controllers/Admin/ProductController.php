<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Product;
use App\Pservice;
use App\Userlog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends AdminController
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
            $products = Product::search($keyword)->latest()->paginate(25);
            return view('Admin.products.all' , compact('products'));
        }
        else
        {
            $products = Product::with('category')->latest()->paginate(25);
          //  return $products;
            return view('Admin.products.all' , compact('products'));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product_services = Pservice::where('status','1')->latest()->get();
        $categories = Category::getTree();
        return view('Admin.products.create',compact('categories','product_services'));
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
            'name' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'unit' => 'required|numeric',
            'allfiles' => 'required',
            'length' => 'required|numeric|min:1',
            'width' => 'required|numeric|min:1',
        ]);

        $allfiles = $request->all('allfiles');

        $price = str_replace(',','',$request->all('price'));

        $partner_price = str_replace(',','',$request->all('partner_price'));

        $partner_urgent_price = str_replace(',','',$request->all('partner_urgent_price'));

        $urgent_price = str_replace(',','',$request->all('urgent_price'));

        if($request->file('images'))
        {
            $imagesUrl = $this->uploadImages($request->file('images'),'product');
        }
        else
        {
            $imagesUrl = null;
        }

        $max_width = $request->input('max_width');
        $max_length = $request->input('max_length');
        if($max_width == null){ $max_width = '0'; }
        if($max_length == null){ $max_length = '0'; }


        foreach($allfiles as $allfile){

            $product = Product::create(array_merge($request->only(
                'name',
                'category_id',
                'body',
                'status',
                'unit',
                'delivery_time',
                'urgent_status',
                'delivery_urgent_time',
                'width',
                'length'
            ) , [
                'max_width' => $max_width,
                'max_length' => $max_length,
                'images' => $imagesUrl,
                'partner_urgent_price' => $partner_urgent_price['partner_urgent_price'],
                'partner_price' => $partner_price['partner_price'],
                'price' => $price['price'],
                'urgent_price' => $urgent_price['urgent_price'],
                'allfiles' => $allfile
            ]));

        }


         //   $category->create(array_merge($request->all() , [ 'images' => $imagesUrl, ]));


        $input_product_services = $request->input('pservice_id');

        $product->pservices()->sync($input_product_services);

        $bodyLog =  ' ثبت محصول   ' . $request->input('name');
        Userlog::create([
            'user_id' => auth()->user()->id,
            'body' => $bodyLog
        ]);

        return redirect(route('products.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {

        $product = Product::with('pservices')->where('id', $product->id)->get();

        $psarray = array();

        foreach ($product[0]->pservices as $ps)
        {
            array_push($psarray,$ps->id);
        }

        $product_services = Pservice::where('status','1')->latest()->get();
        $categories = Category::getTree();
        return view('Admin.products.edit',compact('categories','product_services','product','psarray'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {

        $this->validate($request, [
            'name' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'unit' => 'required|numeric',
            'allfiles' => 'required',
            'length' => 'required|numeric|min:1',
            'width' => 'required|numeric|min:1',
        ]);

        $price = str_replace(',','',$request->all('price'));

        $partner_price = str_replace(',','',$request->all('partner_price'));

        $partner_urgent_price = str_replace(',','',$request->all('partner_urgent_price'));

        $urgent_price = str_replace(',','',$request->all('urgent_price'));

        if($request->file('images'))
        {
            $imagesUrl = $this->uploadImages($request->file('images'),'product');
        }
        else
        {
            $imagesUrl = null;
        }

        $max_width = $request->input('max_width');
        $max_length = $request->input('max_length');
        if($max_width == null){ $max_width = '0'; }
        if($max_length == null){ $max_length = '0'; }

        $allfiles = $request->all('allfiles');

        foreach($allfiles as $allfile) {

            Product::where('id', $product->id)->update(array_merge($request->only(
                'name',
                'category_id',
                'body',
                'status',
                'unit',
                'delivery_time',
                'urgent_status',
                'delivery_urgent_time',
                'length',
                'width'
            ), [
                'max_width' => $max_width,
                'max_length' => $max_length,
                'images' => json_encode($imagesUrl),
                'price' => $price['price'],
                'partner_price' => $partner_price['partner_price'],
                'partner_urgent_price' => $partner_urgent_price['partner_urgent_price'],
                'urgent_price' => $urgent_price['urgent_price'],
                'allfiles' => json_encode($allfile),
            ]));

        }

        $input_product_services = $request->input('pservice_id');

        $product->pservices()->sync($input_product_services);

        $bodyLog =   ' ویرایش محصول   ' . $request->input('name');
        Userlog::create([
            'user_id' => auth()->user()->id,
            'body' => $bodyLog
        ]);

        return redirect(route('products.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {

        $bodyLog =   ' حذف محصول   ' . $product->name;
        Userlog::create([
            'user_id' => auth()->user()->id,
            'body' => $bodyLog
        ]);
        $product->delete();


        alert()->success('','حذف با موفقیت انجام شد');
        return redirect(route('products.index'));
    }
}
