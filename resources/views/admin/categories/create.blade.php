@component('admin.layouts.content',['title' => 'افزودن دسته بندی'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">لیست دسته بندی ها</a></li>
        <li class="breadcrumb-item active">افزودن دسته بندی</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">

            @include('admin.layouts.error')

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">افزودن دسته بندی</h3>
                    <div class="card-tools">
                        <a href="" class="btn btn-sm btn-default text-dark"><i class="fa fa-refresh ml-1"></i>تازه سازی</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="card-body d-flex flex-wrap">
                        <div class="form-group col-lg-6">
                            <label for="inputName" class="col-sm-6 control-label">نام دسته بندی</label>

                            <input type="text" name="name" class="form-control"
                                   id="inputName" placeholder="نام دسته بندی را وارد کنید" value="{{ old('name') }}">
                        </div>

                      @if(request('parent'))
                          @php
                            $parent = \App\Models\Category::find(request('parent'));
                          @endphp
                            <div class="form-group col-lg-6">
                                <label for="parent" class="col-sm-6 control-label">نام دسته بندی والد</label>

                                <input type="text" disabled class="form-control" id="parent" value="{{ $parent->name }}">
                                <input type="hidden" name="parent" value="{{ $parent->id }}">
                            </div>
                      @endif
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info float-left">افزودن<i class="fa fa-plus pr-1"></i>
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-default"><i
                                class="fa fa-arrow-right pl-1"></i>بازگشت</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endcomponent
