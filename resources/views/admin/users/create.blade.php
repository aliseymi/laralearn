@component('admin.layouts.content',['title' => 'افزودن کاربر'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">لیست کاربران</a></li>
        <li class="breadcrumb-item active">افزودن کاربر</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">

            @include('admin.layouts.error')

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">افزودن کاربر</h3>
                    <div class="card-tools">
                        <a href="" class="btn btn-sm btn-default text-dark"><i class="fa fa-refresh ml-1"></i>تازه سازی</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="card-body d-flex flex-wrap">
                        <div class="form-group col-lg-6">
                            <label for="inputName" class="col-sm-2 control-label">نام کاربر</label>

                            <input type="text" name="name" class="form-control"
                                   id="inputName" placeholder="نام کاربر را وارد کنید" value="{{ old('name') }}">
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="inputEmail3" class="col-sm-2 control-label">ایمیل</label>

                            <input type="email" name="email" class="form-control" id="inputEmail3"
                                   placeholder="ایمیل کاربر را وارد کنید" value="{{ old('email') }}">
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="inputPassword3" class="col-sm-2 control-label">پسورد</label>

                            <input type="password" name="password" class="form-control" id="inputPassword3"
                                   placeholder="پسورد را وارد کنید">
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="inputPassword4" class="col-sm-2 control-label">تکرار پسورد</label>

                            <input type="password" name="password_confirmation" class="form-control" id="inputPassword4"
                                   placeholder="پسورد را وارد کنید">
                        </div>

                        <div class="form-group col-lg-6 mt-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="verify" id="verify" style="cursor: pointer">
                                <label for="verify" class="form-check-label" style="cursor: pointer">اکانت فعال باشد</label>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info float-left">افزودن<i class="fa fa-plus pr-1"></i>
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-default"><i
                                class="fa fa-arrow-right pl-1"></i>بازگشت</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endcomponent
