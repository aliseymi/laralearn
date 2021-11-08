<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:create-category')->only(['create','store']);
        $this->middleware('can:show-categories')->only(['index']);
        $this->middleware('can:edit-category')->only(['edit','update']);
        $this->middleware('can:delete-category')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::query();
        if($keyword = \request('search')){
            $categories->where('name','LIKE',"%{$keyword}%");
        }

        $categories = $categories->whereParent(0)->latest()->paginate(20);
        return view('admin.categories.all',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($request->parent){
            $request->validate([
                'name' => 'required|string|min:3',
                'parent' => 'required|exists:categories,id'
            ]);
        }else{
            $request->validate([
                'name' => 'required|string|min:3'
            ]);
        }

        Category::create([
            'name' => $request->name,
            'parent' => $request->parent ?? 0
        ]);

        alert()->success('دسته بندی با موفقیت اضافه شد');
        return redirect(route('admin.categories.index'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|min:3'
        ]);

        $category->update([
            'name' => $request->name,
            'parent' => $request->parent
        ]);

        alert()->success('دسته بندی با موفقیت ویرایش شد');
        return redirect(route('admin.categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        alert()->success('دسته بندی با موفقیت حذف شد');
        return back();
    }
}
