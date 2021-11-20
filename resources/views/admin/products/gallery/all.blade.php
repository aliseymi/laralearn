@component('admin.layouts.content' , ['title' => 'لیست تصاویر'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item">{{ $product->title }}</li>
        <li class="breadcrumb-item active">گالری تصاویر</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">تصاویر</h3>

                    <div class="card-tools d-flex">

                            <div class="btn-group-sm mr-1">
                                <a href="{{ route('admin.products.index') }}" class="btn btn-warning"><i class="fa fa-arrow-right pl-1"></i>بازگشت</a>

                                @can('add-product-gallery')
                                <a href="{{ route('admin.products.gallery.create' , ['product' => $product->id]) }}" class="btn btn-info">ثبت تصویر جدید<i class="fa fa-plus mr-1"></i></a>
                                @endcan
                            </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        @foreach($images as $image)
                            <div class="col-sm-2 img-thumbnail ml-1">
                                <a href="{{ url($image->image) }}">
                                    <img class="img-fluid mb-2" src="{{ url($image->image) }}" alt="{{ $image->image }}">
                                </a>

                                <p class="text-muted">عنوان تصویر: <strong>{{ $image->alt }}</strong></p>

                                <div class="actionButtons">

                                    @can('edit-product-gallery')
                                        <a href="{{ route('admin.products.gallery.edit',['product' => $product->id,'gallery' => $image->id]) }}" class="btn btn-sm btn-success">ویرایش<i class="fa fa-pencil pr-1"></i></a>
                                    @endcan

                                    @can('delete-product-gallery')
                                       <form class="deleteImg d-inline" action="{{ route('admin.products.gallery.destroy',['product' => $product->id,'gallery' => $image->id]) }}" method="POST">
                                           @csrf
                                           @method('DELETE')
                                       </form>
                                       <a href="#" class="btn btn-sm btn-danger deleteBtn">حذف<i class="fa fa-trash pr-1"></i></a>
                                    @endcan
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    {{ $images->render() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>

    @slot('head')
        <style>
            div.img-thumbnail {
                height: 350px;
                max-height: 350px;
            }

            div.actionButtons {
                position: absolute;
                bottom: 5px;
            }
        </style>
    @endslot

    @slot('script')
        <script>
            $('.deleteBtn').on('click',function (e){

                e.preventDefault();

                let deleteBtn = $(this);
                Swal.fire({
                    icon: 'warning',
                    iconColor: '#ff1e00',
                    title: 'آیا از حذف تصویر اطمینان دارید؟',
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
                        deleteBtn.siblings('form.deleteImg').submit();
                    }
                });
            })
        </script>
    @endslot

@endcomponent
