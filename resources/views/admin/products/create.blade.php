@component('admin.layouts.content',['title' => 'افزودن محصول'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">لیست محصولات</a></li>
        <li class="breadcrumb-item active">افزودن محصول</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">

            @include('admin.layouts.error')

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">افزودن محصول</h3>
                    <div class="card-tools">
                        <a href="" class="btn btn-sm btn-default text-dark"><i class="fa fa-refresh ml-1"></i>تازه سازی</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <div id="attributes" data-attributes="{{ json_encode(\App\Models\Attribute::all()->pluck('name')) }}"></div>
                <form class="form-horizontal" action="{{ route('admin.products.store') }}" method="POST">
                    @csrf
                    <div class="card-body d-flex flex-wrap">

                        <div class="form-group col-lg-12">
                            <label for="categories" class="col-sm-4 control-label">دسته بندی</label>
                            <select class="form-control" name="categories[]" id="categories" multiple>
                                @foreach(\App\Models\Category::all() as $cate)
                                    <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="inputName" class="col-sm-2 control-label">نام محصول</label>

                            <input type="text" name="title" class="form-control"
                                   id="inputName" placeholder="نام محصول را وارد کنید" value="{{ old('title') }}">
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="description" class="col-sm-2 control-label">توضیحات</label>

                            <textarea class="form-control" placeholder="توضیحات را وارد کنید" name="description" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="inventory" class="col-sm-2 control-label">تعداد</label>

                            <input type="number" name="inventory" class="form-control" id="inventory"
                                   placeholder="تعداد را وارد کنید" value="{{ old('inventory') }}">
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="price" class="col-sm-2 control-label">قیمت</label>

                            <input type="number" name="price" class="form-control" id="price"
                                   placeholder="قیمت را وارد کنید" value="{{ old('price') }}">
                        </div>


                        <div class="form-group col-lg-12 mt-3">
                            <h6>ویژگی های محصول</h6>
                            <hr>
                            <div id="attribute_section"></div>
                            <button type="button" class="btn btn-sm btn-danger" id="add_product_attribute">ویژگی جدید</button>
                        </div>
                    </div>

                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info float-left">افزودن<i class="fa fa-plus pr-1"></i>
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-default"><i
                                class="fa fa-arrow-right pl-1"></i>بازگشت</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>

    @slot('script')
        <script>
            $('#categories').select2({
                'placeholder': 'لطفا یک دسته بندی را انتخاب کنید',
                dir: 'rtl'
            });

            let changeAttributeValues = (event,id) => {
                let valueBox = $(`select[name="attributes[${id}][value]"]`);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                });

                $.ajax({
                    url: '/admin/attribute/values',
                    type: 'POST',
                    data: JSON.stringify({
                        name: event.target.value
                    }),
                    success: function (res){
                        valueBox.html(`
                            <option value="" selected>لطفا یک مورد را انتخاب کنید</option>
                            ${
                            res.data.map(function (item){
                                return `<option value="${item}">${item}</oprion>`;
                            })
                        }
                        `);
                    }
                });
            }

            let createAttr = ({attributes,id}) => {
                return `
                    <div class="row" id="attribute-${id}">
                        <div class="col-5">
                            <div class="form-group">
                                <label>ویژگی ها</label>
                                <select name="attributes[${id}][name]" onchange="changeAttributeValues(event,${id});" class="form-control attribute-select">
                                    <option value="">لطفا یک مورد را انتخاب کنید</option>
                                        ${
                                attributes.map(function (item){
                                    return `<option value="${item}">${item}</option>`;
                                    })
                                }
                                 </select>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label>مقدار ویژگی ها</label>
                                <select name="attributes[${id}][value]" class="form-control attribute-select">
                                    <option value="" selected>لطفا یک مورد را انتخاب کنید</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-2">
                            <label>اقدامات</label>
                            <div>
                                <button type="button" class="btn btn-sm btn-warning" onclick="document.getElementById('attribute-${id}').remove()">حذف</button>
                            </div>
                        </div>
                    </div>
                `;
            }

            $('#add_product_attribute').click(function (){
                let attributeSection = $('#attribute_section');
                let id = attributeSection.children().length

                let attributes = $('#attributes').data('attributes');

               attributeSection.append(
                   createAttr({
                   attributes,
                   id
               }));

                $('.attribute-select').select2({tags: true,dir: 'rtl'});
            });
        </script>
    @endslot
@endcomponent
