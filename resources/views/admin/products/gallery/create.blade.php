@component('admin.layouts.content' , ['title' => 'ثبت تصویر'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item">{{ $product->title }}</li>
        <li class="breadcrumb-item active">ثبت تصویر</li>
    @endslot

    @slot('script')
        <script>

            let createNewPic = ({id}) => {
                return `
                      <div class="row image-field" id="image-${id}">
                            <div class="col-5">
                                <div class="form-group">
                                        <label>تصویر</label>

                                    <div class="input-group">
                                        <input type="text" dir="ltr" readonly class="form-control image_label" name="images[${id}][image]"
                                       aria-label="Image" aria-describedby="button-image">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary button-image" type="button">انتخاب</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-5">
                               <div class="form-group">
                                     <label>عنوان تصویر</label>

                                    <input type="text" class="form-control" name="images[${id}][alt]">
                               </div>
                            </div>

                            <div class="col-2">
                                <label>اقدامات</label>

                                <div>
                                    <button type="button" onclick="document.getElementById('image-${id}').remove()" class="btn btn-sm btn-warning">حذف</button>
                                </div>
                            </div>
                      </div>
                `;
            }

            $('#add_product_image').click(function (){

                let imagesSection = $('#images_section');
                let id = imagesSection.children().length;

                imagesSection.append(
                    createNewPic({
                        id
                    })
                );
            });

            $('#add_product_image').click();

            // input for image url
            let image
            $('body').on('click','.button-image',(event) => {
                event.preventDefault();

                image = $(event.target).closest('.image-field');

                window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
            });

            // set file link
            function fmSetLink($url) {
                image.find('.image_label').first().val($url)
            }

        </script>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include('admin.layouts.error')
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">ثبت تصویر</h3>

                    <div class="card-tools">
                        <a href="" class="btn btn-sm btn-default text-dark"><i class="fa fa-refresh ml-1"></i>تازه سازی</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ route('admin.products.gallery.store' , ['product' => $product->id]) }}" method="POST">
                    @csrf

                    <div class="card-body">
{{--                        <h6>ویژگی محصول</h6>--}}
{{--                        <hr>--}}
                        <div id="images_section">

                        </div>
                        <button class="btn btn-sm btn-danger" type="button" id="add_product_image">تصویر جدید</button>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info float-left">ثبت تصاویر<i class="fa fa-plus pr-1"></i>
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
