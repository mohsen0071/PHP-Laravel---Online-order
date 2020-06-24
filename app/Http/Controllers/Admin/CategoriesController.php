<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Userlog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gate;

class CategoriesController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      //  if (Gate::allows('list-category')) {
            if (request('search')) {
                $keyword = request('search');

                $categories = Category::search($keyword);
                //   return $clients;
                return view('Admin.categories.all', [
                    'categories' => $categories->get()->toHierarchy()
                ]);
            } else {
                $query = Category::query();
                return view('Admin.categories.all', [
                    'categories' => $query->get()->toHierarchy()
                ]);
            }
      //  }



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::getTree();
      //  return $categories;
        return view('Admin.categories.create', compact('categories'));
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
            'parent_id' => 'nullable|exists:categories,id',
            'name' => 'required',
            'sheet_count' => 'required|numeric',
        ]);

        $category = new Category($request->all());

        if($request->file('images'))
        {
            $imagesUrl = $this->uploadImages($request->file('images'),'category');
        }
        else
        {
            $imagesUrl = null;
        }


        $category->create(array_merge($request->all() , [ 'images' => $imagesUrl]));

        $bodyLog = $request->input('name').' افزودن دسته بندی ';
        Userlog::create([
            'user_id' => auth()->user()->id,
            'body' => $bodyLog
        ]);

        return redirect(route('categories.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {

        $categories = Category::getTree();
        return view('Admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        $oldCatName = $category->name;

        $this->validate($request, [
            'parent_id' => 'nullable|exists:categories,id',
            'name' => 'required',
            'sheet_count' => 'required|numeric',
      //      'allfiles' => 'required',
        ]);

        $category = new Category($request->all());

        if($request->file('images'))
        {
            $imagesUrl = $this->uploadImages($request->file('images'),'category');
        }
        else
        {
            $imagesUrl = $category->images;
        }
       // return array_merge($imagesUrl);
        $inputs = $request->all();

        if(isset($inputs['parent_id']))
        {
            if($id == $inputs['parent_id'])
            {
                alert()->error('','مشکلی در ویرایش بوجود آمده است');
                return redirect(route('categories.index'));
            }

        }

      //  $allfiles = $request->all('allfiles');

      //  foreach($allfiles as $allfile) {
            Category::where('id', $id)->update([
                'parent_id' => $inputs['parent_id'],
                'name' => $inputs['name'],
                'description' => $inputs['description'],
                'images' => json_encode($imagesUrl),
                'status' => $inputs['status'],
                'sheet_count' => $inputs['sheet_count'],
            //    'allfiles' => json_encode($allfile),
                'pservice_unit' => $inputs['pservice_unit']
            ]);
     //   }

        $bodyLog =  ' ویرایش دسته بندی '. $inputs['name'];
        Userlog::create([
            'user_id' => auth()->user()->id,
            'body' => $bodyLog
        ]);

        alert()->success('','ویرایش با موفقیت انجام شد');
        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $count = Category::getChildren($id);

        $category = Category::where('id',$id)->first();

        if($count == 0)
        {
            $category = Category::find($id);
            $category->delete();
            alert()->success('','حذف با موفقیت انجام شد');
        }
        else
        {
            alert()->error('','حذف امکان پذیر نیست');
        }

        $bodyLog = ' حذف دسته بندی '.$category->name;
        Userlog::create([
            'user_id' => auth()->user()->id,
            'body' => $bodyLog
        ]);

        return redirect(route('categories.index'));
    }
}
