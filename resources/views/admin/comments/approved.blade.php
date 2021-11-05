@component('admin.layouts.content',['title' => 'لیست نظرات تایید شده'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item active">لیست نظرات تایید شده</li>
    @endslot
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">لیست نظرات تایید شده</h3>

                    <div class="card-tools d-flex">
                        <form action="">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="search" class="form-control float-right" placeholder="جستجو" value="{{ old('search') }}">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-center">
                        <tbody>
                        <tr>
                            <th>آیدی نظر</th>
                            <th>نام کاربر</th>
                            <th>متن</th>
                            <th>اقدامات</th>
                        </tr>
                        @foreach($comments as $comment)
                            <tr>
                                <td>{{ $comment->id }}</td>
                                <td>{{ $comment->user->name }}</td>
                                <td>{{ $comment->comment }}</td>
                                <td class="d-flex justify-content-center">
                                    @can('delete-comment')
                                        <form action="{{ route('admin.comments.destroy',['comment' => $comment->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger ml-1 deleteComment"><i class="fa fa-trash"></i></button>
                                        </form>
                                    @endcan
                                    @can('edit-comment')
                                            <a href="{{ route('admin.comments.edit', $comment->id) }}" class="btn btn-sm btn-success ml-1"><i class="fa fa-edit"></i></a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    {{ $comments->appends(['search' => request('search')])->render() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>

    @slot('script')
        <script>
            $('.deleteComment').on('click',function (){
                let deleteBtn = $(this);
                Swal.fire({
                    icon: 'warning',
                    iconColor: '#ff1e00',
                    title: 'آیا از حذف نظر اطمینان دارید؟',
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

