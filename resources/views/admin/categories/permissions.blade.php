@component('admin.layouts.content',['title' => 'دسترسی های کاربر'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">لیست کاربران</a></li>
        <li class="breadcrumb-item active">دسترسی های کاربر</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">

            @include('admin.layouts.error')

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">دسترسی های کاربر</h3>
                    <div class="card-tools">
                        <a href="" class="btn btn-sm btn-default text-dark"><i class="fa fa-refresh ml-1"></i>تازه سازی</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ route('admin.users.permissions.store', $user->id) }}" method="POST">
                    @csrf
                    <div class="card-body d-flex flex-wrap">

                        <div class="form-group col-lg-12">
                            <label for="roles" class="col-sm-4 control-label">مقام ها</label>
                            <select class="form-control" name="roles[]" id="roles" multiple>
                                @foreach(\App\Models\Role::all() as $role)
                                    <option value="{{ $role->id }}" {{ $user->roles->contains('id',$role->id) ? 'selected' : '' }}>{{ $role->name }} - {{ $role->label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="permissions" class="col-sm-4 control-label">دسترسی ها</label>
                            <select class="form-control" name="permissions[]" id="permissions" multiple>
                                @foreach(\App\Models\Permission::all() as $permission)
                                    <option value="{{ $permission->id }}" {{ $user->permissions->contains('id',$permission->id) ? 'selected' : '' }}>{{ $permission->name }} - {{ $permission->label }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info float-left">ثبت<i class="fa fa-plus pr-1"></i>
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-default"><i
                                class="fa fa-arrow-right pl-1"></i>بازگشت</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>

    @slot('script')
        <script>
            $('#roles').select2({
                'placeholder': 'مقام های مورد نظر را انتخاب کنید',
                dir: 'rtl'
            });

            $('#permissions').select2({
                'placeholder': 'دسترسی های مورد نظر را انتخاب کنید',
                dir: 'rtl'
            });
        </script>
    @endslot
@endcomponent
