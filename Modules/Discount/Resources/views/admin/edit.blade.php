@component('admin.layouts.content' , ['title' => 'ویرایش کد تخفیف'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.discount.index') }}">لیست تخفیف‌ها</a></li>
        <li class="breadcrumb-item active">ویرایش کد تخفیف</li>
    @endslot

    @slot('script')
        <script>

            $('#users').select2({
                'placeholder' : 'کاربر مورد نظر را انتخاب کنید',
                dir: 'rtl'
            })

            $('#products').select2({
                'placeholder' : 'محصول مورد نظر را انتخاب کنید',
                dir: 'rtl'
            })

            $('#categories').select2({
                'placeholder' : 'دسته مورد نظر را انتخاب کنید',
                dir: 'rtl'
            })

            $('#dtp').MdPersianDateTimePicker({
                targetTextSelector: '#persianText',
                targetDateSelector: '#persianDate',
                textFormat: 'dddd dd MMMM yyyy',
                enableTimePicker: true
            });
        </script>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include('admin.layouts.error')
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">فرم ویرایش کد تخفیف</h3>

                    <div class="card-tools">
                        <a href="" class="btn btn-sm btn-default text-dark"><i class="fa fa-refresh ml-1"></i>تازه سازی</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ route('admin.discount.update', $discount->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="card-body d-flex flex-wrap">
                        <div class="form-group col-lg-6">
                            <label for="inputEmail3" class="control-label">کد تخفیف</label>
                            <input type="text" name="code" class="form-control" id="inputEmail3" placeholder="کد تخفیف را وارد کنید" value="{{ old('code',$discount->code) }}">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="percent" class="control-label">میزان تخفیف (درصد)</label>
                            <input type="number" name="percent" class="form-control" placeholder="درصد تخفیف را وارد کنید" value="{{ old('percent',$discount->percent) }}">
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="control-label">کاربر مربوط به تخفیف (اختیاری)</label>
                            <select class="form-control" name="users[]" id="users" multiple>
                                <option value="null">همه کاربرها</option>
                                @foreach(\App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}" {{ $discount->users->contains('id',$user->id) ? 'selected' : '' }}>{{ $user->email }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="inputPassword3" class="control-label">محصول مربوطه (اختیاری)</label>
                            <select class="form-control" name="products[]" id="products" multiple>
                                <option value="null">همه محصولات</option>
                                @foreach(\App\Models\Product::all() as $product)
                                    <option value="{{ $product->id }}" {{ $discount->products->contains('id',$product->id) ? 'selected' : '' }}>{{ $product->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="inputPassword3" class="control-label">دسته‌بندی مربوطه (اختیاری)</label>
                            <select class="form-control" name="categories[]" id="categories" multiple>
                                <option value="null">همه دسته بندی‌ها</option>
                                @foreach(\App\Models\Category::all() as $category)
                                    <option value="{{ $category->id }}" {{ $discount->categories->contains('id',$category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="inputEmail3" class="control-label">مهلت استفاده</label>
{{--                            <input type="datetime-local" name="expired_at" class="form-control" id="inputEmail3" placeholder="ملهت استفاده را وارد کنید" value="{{ old('expired_at', \Carbon\Carbon::parse($discount->expired_at)->format('Y-m-d\TH:i:s')) }}">--}}
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="cursor: pointer;" id="dtp">📅</span>
                                </div>
                                <input type="text" placeholder="تاریخ انقضای کد تخفیف را مشخص کنید" disabled id="persianText" class="form-control">
                                <input type="text" readonly id="persianDate" class="form-control d-none" name="expired_at" value="{{ old('expired-at',$discount->expired_at) }}">
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info float-left">ویرایش کد تخفیف<i class="fa fa-edit pr-1"></i>
                        </button>
                        <a href="{{ route('admin.discount.index') }}" class="btn btn-default"><i
                                class="fa fa-arrow-right pl-1"></i>بازگشت</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>



@endcomponent
