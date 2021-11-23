@component('admin.layouts.content' , ['title' => 'لیست تخفیف'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item active">لیست تخفیف‌ها</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">تخفیف‌ها</h3>

                    <div class="card-tools d-flex">
                        <form action="">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="search" class="form-control float-right" placeholder="جستجو" value="{{ request('search') }}">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                        <div class="btn-group-sm mr-1">
                            @can('create-discount')
                                <a href="{{ route('admin.discount.create') }}" class="btn btn-info">ایجاد تخفیف جدید<i class="fa fa-plus pr-1"></i></a>
                            @endcan
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-center">
                        <tbody>
                        <tr>
                            <th>آی‌دی تخفیف</th>
                            <th>کد تخفیف</th>
                            <th>میزان تخفیف (درصد)</th>
                            <th>مربوط به کاربر</th>
                            <th>مربوط به محصول</th>
                            <th>مربوط به دسته</th>
                            <th>مهلت استفاده</th>
                            <th>اقدامات</th>
                        </tr>

                        @foreach($discounts as $discount)
                            <tr>
                                <td>{{ $discount->id }}</td>
                                <td>{{ $discount->code }}</td>
                                <td>{{ $discount->percent }}</td>
                                <td>{{ $discount->users->count() ? $discount->users->pluck('name')->join(', ') : 'همه کاربران' }}</td>
                                <td>{{ $discount->products->count() ? $discount->products->pluck('title')->join(', ') : 'همه محصولات' }}</td>
                                <td>{{ $discount->categories->count() ?  $discount->categories->pluck('name')->join(', ') : 'همه دسته‌ها' }}</td>
                                <td>{{ jdate($discount->expired_at)->ago() }}</td>
                                <td class="d-flex">
{{--                                    // permissions--}}
                                    @can('delete-discount')
                                        <form action="{{ route('admin.discount.destroy',['discount' => $discount->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger ml-1 deleteDiscount"><i class="fa fa-trash"></i></button>
                                        </form>
                                    @endcan

                                    @can('edit-discount')
                                        <a href="{{ route('admin.discount.edit', $discount->id) }}" class="btn btn-sm btn-success ml-1"><i class="fa fa-edit"></i></a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    {{ $discounts->appends([ 'search' => request('search') ])->render() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>


    @slot('script')
        <script>
            $('.deleteDiscount').on('click',function (){
                let deleteBtn = $(this);
                Swal.fire({
                    icon: 'warning',
                    iconColor: '#ff1e00',
                    title: 'آیا از حذف این کد تخفیف اطمینان دارید؟',
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
