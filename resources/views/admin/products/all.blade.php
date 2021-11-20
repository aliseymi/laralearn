@component('admin.layouts.content',['title' => 'لیست محصولات'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item active">لیست محصولات</li>
    @endslot
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">لیست محصولات</h3>

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
                            @can('create-product')
                                <a href="{{ route('admin.products.create') }}" class="btn btn-info mr-1">افزودن محصول<i class="fa fa-plus pr-1"></i></a>
                            @endcan
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-center">
                        <tbody>
                        <tr>
                            <th>آیدی محصول</th>
                            <th>نام محصول</th>
                            <th>موجودی</th>
                            <th>تعداد بازدید</th>
                            <th>اقدامات</th>
                        </tr>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->title }}</td>
                                <td>{{ $product->inventory }}</td>
                                <td>{{ $product->view_count }}</td>

                                <td class="d-flex justify-content-center">
                                    @can('delete-product')
                                        <form action="{{ route('admin.products.destroy',['product' => $product->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger ml-1 deleteProduct"><i class="fa fa-trash"></i></button>
                                        </form>
                                    @endcan
                                    @can('edit-product')
                                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-success ml-1"><i class="fa fa-edit"></i></a>
                                    @endcan

                                    @can('show-product-gallery')
                                            <a href="{{ route('admin.products.gallery.index', ['product' => $product->id]) }}" class="btn btn-sm btn-warning ml-1" data-toggle="tooltip" title="گالری تصاویر"><i class="fa fa-image"></i></a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    {{ $products->appends(['search' => request('search')])->render() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>

    @slot('script')
        <script>
            $('.deleteProduct').on('click',function (){
                let deleteBtn = $(this);
                Swal.fire({
                    icon: 'warning',
                    iconColor: '#ff1e00',
                    title: 'آیا از حذف محصول اطمینان دارید؟',
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

