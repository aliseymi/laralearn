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
                                <input type="text" name="search" class="form-control float-right" placeholder="جستجو">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>

                        <div class="btn-group-sm">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-info mr-1">افزودن کاربر<i class="fa fa-plus pr-1"></i></a>
                            <a href="{{ request()->fullUrlWithoutQuery(['search','admin','sort']) . '?admin=1' }}" class="btn btn-warning">کاربران ادمین<i class="fa fa-user pr-1"></i></a>
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
                                    <form action="{{ route('admin.users.destroy',['user' => $user->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger ml-1"><i class="fa fa-trash deleteUser"></i></button>
                                    </form>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-success"><i class="fa fa-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    {{ $users->render() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endcomponent
