@component('admin.layouts.content',['title' => 'لیست کاربران'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item active">لیست کاربران</li>
    @endslot
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">لیست کاربران</h3>

                    <div class="card-tools d-flex">
                        <form action="">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="search" class="form-control float-right" placeholder="جستجو" value="{{ old('search') }}">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>

                        <div class="btn-group-sm">
                            @can('create-user')
                                <a href="{{ route('admin.users.create') }}" class="btn btn-info mr-1">افزودن کاربر<i class="fa fa-plus pr-1"></i></a>
                            @endcan
                            @can('show-staff-users')
                                    <a href="{{ request()->fullUrlWithoutQuery(['search','admin','sort']) . '?admin=1' }}" class="btn btn-warning">کاربران ادمین<i class="fa fa-user pr-1"></i></a>
                            @endcan
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-center">
                        <tbody>
                        <tr>
                            <th>آیدی کاربر</th>
                            <th>نام کاربر</th>
                            <th>ایمیل</th>
                            <th>وضعیت</th>
                            <th>اقدامات</th>
                        </tr>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                @if($user->hasVerifiedEmail())
                                    <td><span class="badge badge-success">فعال</span></td>
                                @else
                                    <td><span class="badge badge-danger">غیرفعال</span></td>
                                @endif
                                <td class="d-flex justify-content-center">
                                    @can('delete-user')
                                        <form action="{{ route('admin.users.destroy',['user' => $user->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger ml-1 deleteUser"><i class="fa fa-trash"></i></button>
                                        </form>
                                    @endcan
                                    @can('edit-user')
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-success ml-1"><i class="fa fa-edit"></i></a>
                                    @endcan
                                   @can('staff-user-permissions')
                                            @if($user->isStaff())
                                                <a href="{{ route('admin.users.permissions', $user->id) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="دسترسی های کاربر"><i class="fa fa-id-card-o"></i></a>
                                            @endif
                                   @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    {{ $users->appends(['search' => request('search')])->render() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>

    @slot('script')
        <script>
            $('.deleteUser').on('click',function (){
                let deleteBtn = $(this);
                Swal.fire({
                    icon: 'warning',
                    iconColor: '#ff1e00',
                    title: 'آیا از حذف کاربر اطمینان دارید؟',
                    text: 'پس از حذف،امکان بازگردانی عملیات وجود ندارد!',
                    showConfirmButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'بله',
                    confirmButtonColor: '#28a745',
                    cancelButtonText: 'منصرف شدم',
                    cancelButtonColor: '#ff2200',
                    reverseButtons:true,
                    focusCancel: true,
                }).then((result) => {
                    if(result.isConfirmed){
                        deleteBtn.closest('form').submit();
                    }
                });
            })
        </script>
    @endslot
@endcomponent

