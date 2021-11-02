@component('admin.layouts.content',['title' => 'لیست دسترسی ها'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item active">لیست دسترسی ها</li>
    @endslot
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">لیست دسترسی ها</h3>

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
                            @can('create-permission')
                            <a href="{{ route('admin.permissions.create') }}" class="btn btn-info mr-1">افزودن دسترسی<i class="fa fa-plus pr-1"></i></a>
                            @endcan
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-center">
                        <tbody>
                        <tr>
                            <th>عنوان دسترسی</th>
                            <th>توضیح دسترسی</th>
                            <th>اقدامات</th>
                        </tr>
                        @foreach($permissions as $permission)
                            <tr>
                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->label }}</td>

                                <td class="d-flex justify-content-center">
                                  @can('delete-permission')
                                        <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger ml-1"><i class="fa fa-trash deletePermission"></i></button>
                                        </form>
                                  @endcan
                                    @can('edit-permission')
                                          <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="btn btn-sm btn-success"><i class="fa fa-edit"></i></a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    {{ $permissions->appends(['search' => request('search')])->render() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>

    @slot('script')
        <script>
            $('.deletePermission').on('click',function (){
                let deleteBtn = $(this);
                Swal.fire({
                    icon: 'warning',
                    iconColor: '#ff1e00',
                    title: 'آیا از حذف دسترسی اطمینان دارید؟',
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

