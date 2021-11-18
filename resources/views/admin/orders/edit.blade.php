@component('admin.layouts.content' , ['title' => 'ویرایش سفارش'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">لیست سفارشات</a></li>
        <li class="breadcrumb-item active">ویرایش سفارش</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include('admin.layouts.error')
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">ویرایش سفارش</h3>
                    <div class="card-tools">
                        <a href="" class="btn btn-sm btn-default text-dark"><i class="fa fa-refresh ml-1"></i>تازه سازی</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="card-body d-flex flex-wrap">
                        <div class="form-group col-lg-6">
                            <label for="inputEmail3" class="col-sm-4 control-label">شماره سفارش</label>
                            <input type="text" class="form-control" id="inputEmail3" value="{{ $order->id }}" disabled>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="inputEmail3" class="col-sm-4 control-label">هزینه سفارش</label>
                            <input type="number" class="form-control" id="inputEmail3" disabled value="{{ $order->price }}">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="inputPassword3" class="col-sm-4 control-label">وضعیت سفارش</label>
                            <select name="status" class="form-control" id="statusBox">
                                <option value="unpaid" {{ old('status' , $order->status) == 'unpaid' ? 'selected' : '' }}>پرداخت نشده</option>
                                <option value="paid" {{ old('status' , $order->status) == 'paid' ? 'selected' : '' }}>پرداخت شده</option>
                                <option value="preparation" {{ old('status' , $order->status) == 'preparation' ? 'selected' : '' }}>در حال پردازش</option>
                                <option value="posted" {{ old('status' , $order->status) == 'posted' ? 'selected' : '' }}>ارسال شد</option>
                                <option value="received" {{ old('status' , $order->status) == 'received' ? 'selected' : '' }}>دریافت شد</option>
                                <option value="canceled" {{ old('status' , $order->status) == 'canceled' ? 'selected' : '' }}>کنسل شده</option>
                            </select>

                        </div>
                        <div class="form-group col-lg-6">
                            <label for="inputPassword3" class="col-sm-4 control-label">کد پیگیری</label>
                            <input type="text" name="tracking_serial" class="form-control" id="inputPassword3" placeholder="کد پیگیری را وارد کنید" value="{{ old('tracking_serial', $order->tracking_serial )}}">
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info float-left">ویرایش<i class="fa fa-edit pr-1"></i>
                        </button>
                        <a href="{{ route('admin.orders.index',['type' => $order->status]) }}" class="btn btn-default"><i
                                class="fa fa-arrow-right pl-1"></i>بازگشت</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>

    @slot('script')
        <script>
            $('#statusBox').select2({
                dir: 'rtl'
            });
        </script>
    @endslot

@endcomponent
