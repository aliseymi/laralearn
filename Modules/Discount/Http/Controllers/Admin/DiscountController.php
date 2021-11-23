<?php

namespace Modules\Discount\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Modules\Discount\Entities\Discount;

class DiscountController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:show-discounts')->only(['index']);
        $this->middleware('can:create-discount')->only(['create','store']);
        $this->middleware('can:edit-discount')->only(['edit','update']);
        $this->middleware('can:delete-discount')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $discounts = Discount::query();

        if($keyword = \request('search')){
            $discounts->where('code',$keyword)->orWhere('id',$keyword)->orWhere('percent',$keyword)
                ->orWhereHas('users',function ($query) use($keyword){
                    $query->where('name','LIKE',"%{$keyword}%");
                })
                ->orWhereHas('products',function ($query) use($keyword){
                    $query->where('title','LIKE',"%{$keyword}%");
                })
                ->orWhereHas('categories',function ($query) use($keyword){
                    $query->where('name','LIKE',"%{$keyword}%");
                });
        }

        $discounts = $discounts->latest()->paginate(20);

        return view('discount::admin.all',compact('discounts'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('discount::admin.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:discounts,code',
            'percent' => 'required|integer|between:1,99',
            'expired_at' => 'required|date|after_or_equal:today'
        ]);

        $discount = Discount::create($validated);

        $this->attachDependentData($request, $discount);

        alert()->success('افزودن کد تخفیف با موفقیت انجام شد');

        return redirect(route('admin.discount.index'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param Discount $discount
     * @return Renderable
     */
    public function edit(Discount $discount)
    {
        return view('discount::admin.edit',compact('discount'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Discount $discount
     * @return Renderable
     */
    public function update(Request $request, Discount $discount)
    {
        $validated = $request->validate([
            'code' => ['required',Rule::unique('discounts','code')->ignore($discount->id)],
            'percent' => 'required|integer|between:1,99',
            'expired_at' => 'required|date|after_or_equal:today'
        ]);

        $discount->update($validated);

        $discount->users()->detach();
        $discount->products()->detach();
        $discount->categories()->detach();

        $this->attachDependentData($request,$discount);

        alert()->success('ویرایش کد تخفیف با موفقیت انجام شد');

        return redirect(route('admin.discount.index'));
    }

    /**
     * Remove the specified resource from storage.
     * @param Discount $discount
     * @return Renderable
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();

        alert()->success('کد تخفیف با موفقیت حذف شد');

        return back();
    }

    /**
     * @param Request $request
     * @param $discount
     */
    protected function attachDependentData(Request $request, $discount): void
    {
        if (isset($request->users)) {
            if (in_array('null', $request->users)) {
                $request->validate([
                    'users' => 'nullable|array'
                ]);
            } else {
                $request->validate([
                    'array|exists: users,id'
                ]);
                $discount->users()->attach($request->users);
            }
        }

        if (isset($request->products)) {
            if (in_array('null', $request->products)) {
                $request->validate([
                    'products' => 'nullable|array'
                ]);
            } else {
                $request->validate([
                    'array|exists: products,id'
                ]);
                $discount->products()->attach($request->products);
            }
        }

        if (isset($request->categories)) {
            if (in_array('null', $request->categories)) {
                $request->validate([
                    'categories' => 'nullable|array'
                ]);
            } else {
                $request->validate([
                    'array|exists: categories,id'
                ]);
                $discount->categories()->attach($request->categories);
            }
        }
    }
}
