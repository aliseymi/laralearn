<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Http\Request;

class ProductGalleryController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:show-product-gallery')->only(['index']);
        $this->middleware('can:delete-product-gallery')->only(['destroy']);
        $this->middleware('can:edit-product-gallery')->only(['edit','update']);
        $this->middleware('can:add-product-gallery')->only(['create','store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $images = $product->galleries()->latest()->paginate(10);

        return view('admin.products.gallery.all',compact('product','images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        return view('admin.products.gallery.create',compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Product $product)
    {
        $validData = $request->validate([
            'images.*.image' => 'required',
            'images.*.alt' => 'required|min:3'
        ]);

        collect($validData['images'])->each(function ($image) use($product){
            $product->galleries()->create($image);
        });

        alert()->success('افزودن تصویر به گالری با موفقیت انجام شد');

        return redirect(route('admin.products.gallery.index',['product' => $product->id]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product,ProductGallery $gallery)
    {
        return view('admin.products.gallery.edit',compact('product','gallery'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product,ProductGallery $gallery)
    {
        $validData = $request->validate([
            'image' => 'required',
            'alt' => 'required|min:3'
        ]);

        $gallery->update($validData);

        alert()->success('تصویر مورد نظر با موفقیت ویرایش شد');

        return redirect(route('admin.products.gallery.index',['product' => $product->id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product,ProductGallery $gallery)
    {
        $gallery->delete();

        alert()->success('تصویر مورد نظر با موفقیت از گالری محصول حذف شد');

        return redirect(route('admin.products.gallery.index',['product' => $product->id]));
    }
}
