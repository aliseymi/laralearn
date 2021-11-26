@component('admin.layouts.content' , ['title' => 'مدیریت ماژول ها'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item active">مدیریت ماژول ها</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ماژول ها</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        @foreach($modules as $module)

                            @php
                                $moduleData = new \Nwidart\Modules\Json($module->getExtraPath('module.json'));
                            @endphp
                        <div class="col-sm-2 img-thumbnail ml-3">
                            <div class="mt-4">
                                <h4>{{ $moduleData->get('alias') }}</h4>
                                <p>{{ $moduleData->get('description') }}</p>
                            </div>

                            @can('disable-or-enable-module')
                                @if(Module::canDisable($module->getName()))
                                    <div class="actionButtons">
                                        @if(Module::isEnable($module->getName()))
                                            <form action="{{ route('admin.modules.disable',['module' => $module->getName()]) }}" method="POST" id="{{ $module->getName() }}-disable">
                                                @csrf
                                                @method('PATCH')
                                            </form>

                                            <a href="#" onclick="event.preventDefault();document.getElementById('{{ $module->getName() }}-disable').submit()" class="btn btn-sm btn-danger">غیرفعالسازی</a>
                                        @else
                                            <form action="{{ route('admin.modules.enable',['module' => $module->getName()]) }}" method="POST" id="{{ $module->getName() }}-enable">
                                                @csrf
                                                @method('PATCH')
                                            </form>

                                            <a href="#" onclick="event.preventDefault();document.getElementById('{{ $module->getName() }}-enable').submit()" class="btn btn-sm btn-success">فعالسازی</a>
                                        @endif
                                    </div>
                                @endif
                            @endcan
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
{{--                    {{ $modules->render() }}--}}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>

    @slot('head')
        <style>
            div.img-thumbnail {
                height: 250px;
                max-height: 250px;
            }

            div.actionButtons {
                position: absolute;
                bottom: 10px;
                right: 10px;
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
