@component('admin.layouts.content',['title' => 'افزودن مقام'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">لیست مقام ها</a></li>
        <li class="breadcrumb-item active">افزودن مقام</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">

            @include('admin.layouts.error')

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">افزودن مقام</h3>
                    <div class="card-tools">
                        <a href="" class="btn btn-sm btn-default text-dark"><i class="fa fa-refresh ml-1"></i>تازه سازی</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ route('admin.roles.store') }}" method="POST">
                    @csrf
                    <div class="card-body d-flex flex-wrap">
                        <div class="form-group col-lg-6">
                            <label for="inputName" class="col-sm-4 control-label">عنوان مقام</label>

                            <input type="text" name="name" class="form-control"
                                   id="inputName" placeholder="عنوان مقام را وارد کنید" value="{{ old('name') }}">
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="inputLabel3" class="col-sm-4 control-label">توضیح مقام</label>

                            <input type="text" name="label" class="form-control" id="inputLabel3"
                                   placeholder="توضیح مقام را وارد کنید" value="{{ old('label') }}">
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="selectPermission" class="col-sm-4 control-label">توضیح مقام</label>
                            <select class="form-control" name="permissions[]" id="selectPermission" multiple>
                                @foreach(\App\Models\Permission::all() as $permission)
                                    <option value="{{ $permission->id }}">{{ $permission->name }} - {{ $permission->label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info float-left">افزودن<i class="fa fa-plus pr-1"></i>
                        </button>
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-default"><i
                                class="fa fa-arrow-right pl-1"></i>بازگشت</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endcomponent
