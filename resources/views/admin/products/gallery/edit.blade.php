@component('admin.layouts.content' , ['title' => 'ویرایش تصویر'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item">{{ $product->title }}</li>
        <li class="breadcrumb-item active">ویرایش تصویر</li>
    @endslot

    @slot('script')
        <script>
            // input
            let image;
            $('body').on('click','.button-image' , (event) => {
                event.preventDefault();

                image = $(event.target).closest('.image-field');

                window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
            });

            // set file link
            function fmSetLink($url) {
                image.find('.image_label').first().val($url);
            }
        </script>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include('admin.layouts.error')
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">ویرایش تصویر</h3>

                    <div class="card-tools">
                        <a href="" class="btn btn-sm btn-default text-dark"><i class="fa fa-refresh ml-1"></i>تازه سازی</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ route('admin.products.gallery.update' , ['product' => $product->id, 'gallery' => $gallery->id ]) }}" method="POST">
                    @csrf
                    @method('patch')

                    <div class="card-body">
{{--                        <h6>ویژگی محصول</h6>--}}
{{--                        <hr>--}}
                        <div id="images_section">
                            <div class="row image-field">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>تصویر</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control image_label" dir="ltr" readonly name="image" value="{{ old('image' , $gallery->image) }}"
                                                   aria-label="Image" aria-describedby="button-image">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary button-image" type="button">انتخاب</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>عنوان تصویر</label>
                                        <input type="text" name="alt" class="form-control" value="{{ old('alt' , $gallery->alt) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info float-left">ویرایش تصویر<i class="fa fa-edit pr-1"></i>
                        </button>
                        <a href="{{ route('admin.products.gallery.index',['product' => $product->id]) }}" class="btn btn-default"><i
                                class="fa fa-arrow-right pl-1"></i>بازگشت</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>



@endcomponent
