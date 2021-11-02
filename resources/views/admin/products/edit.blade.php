@component('admin.layouts.content',['title' => 'ویرایش محصول'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">لیست محصولات</a></li>
        <li class="breadcrumb-item active">ویرایش محصول</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">

            @include('admin.layouts.error')

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">ویرایش محصول</h3>
                    <div class="card-tools">
                        <a href="" class="btn btn-sm btn-default text-dark"><i class="fa fa-refresh ml-1"></i>تازه سازی</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ route('admin.products.update',$product->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="card-body d-flex flex-wrap">
                        <div class="form-group col-lg-12">
                            <label for="inputName" class="col-sm-2 control-label">نام محصول</label>

                            <input type="text" name="title" class="form-control"
                                   id="inputName" placeholder="نام محصول را وارد کنید" value="{{ old('title',$product->title) }}">
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="description" class="col-sm-2 control-label">توضیحات</label>

                            <textarea class="form-control" placeholder="توضیحات را وارد کنید" name="description" id="description" cols="30" rows="10">{{ old('description',$product->description) }}</textarea>
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="inventory" class="col-sm-2 control-label">تعداد</label>

                            <input type="number" name="inventory" class="form-control" id="inventory"
                                   placeholder="تعداد را وارد کنید" value="{{ old('inventory',$product->inventory) }}">
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="price" class="col-sm-2 control-label">قیمت</label>

                            <input type="number" name="price" class="form-control" id="price"
                                   placeholder="قیمت را وارد کنید" value="{{ old('price',$product->price) }}">
                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info float-left">ویرایش<i class="fa fa-edit pr-1"></i>
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-default"><i
                                class="fa fa-arrow-right pl-1"></i>بازگشت</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endcomponent
