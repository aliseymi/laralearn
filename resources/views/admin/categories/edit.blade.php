@component('admin.layouts.content',['title' => 'ویرایش دسته بندی'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">لیست دسته بندی ها</a></li>
        <li class="breadcrumb-item active">ویرایش دسته بندی</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">

            @include('admin.layouts.error')

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">ویرایش دسته بندی</h3>
                    <div class="card-tools">
                        <a href="" class="btn btn-sm btn-default text-dark"><i class="fa fa-refresh ml-1"></i>تازه سازی</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ route('admin.categories.update',$category->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="card-body d-flex flex-wrap">
                        <div class="form-group col-lg-6">
                            <label for="inputName" class="col-sm-6 control-label">نام دسته بندی</label>

                            <input type="text" name="name" class="form-control"
                                   id="inputName" placeholder="نام دسته بندی را وارد کنید" value="{{ old('name',$category->name) }}">
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="parent" class="col-sm-4 control-label">دسته بندی والد</label>
                            <select class="form-control" name="parent" id="parent">
                                <option value="0" selected disabled>درصورت نیاز یک دسته بندی را انتخاب کنید</option>
                                @foreach(\App\Models\Category::all() as $cate)
                                    @if($cate->id === $category->id)
                                        @continue
                                    @endif
                                    <option value="{{ $cate->id }}" {{ $cate->id === $category->parent ? 'selected' : '' }}>{{ $cate->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info float-left">ویرایش<i class="fa fa-edit pr-1"></i>
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-default"><i
                                class="fa fa-arrow-right pl-1"></i>بازگشت</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>

    @slot('script')
        <script>
            $('#parent').select2({
                dir: 'rtl'
            });
        </script>
    @endslot
@endcomponent
