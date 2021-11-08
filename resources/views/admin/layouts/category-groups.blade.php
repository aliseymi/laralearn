<ul class="list-group list-group-flush">
    @foreach($categories as $cate)
        <li class="list-group-item">
            <div class="d-flex">
                <span>{{ $cate->name }}</span>
                <div class="actions mr-2">
                    <form action="{{ route('admin.categories.destroy',$cate->id) }}" id="delete-{{ $cate->id }}-category" class="deleteCategory" method="POST">
                        @csrf
                        @method('delete')
                    </form>
                    @can('delete-category')
                    <a href="#" class="badge badge-danger deleteBtn">حذف<i class="fa fa-trash pr-1"></i></a>
                    @endcan
                    @can('edit-category')
                    <a href="{{ route('admin.categories.edit',$cate->id) }}" class="badge badge-primary">ویرایش<i class="fa fa-edit pr-1"></i></a>
                    @endcan
                    @can('create-category')
                    <a href="{{ route('admin.categories.create') }}?parent={{ $cate->id }}" class="badge badge-warning">ثبت زیر دسته<i class="fa fa-plus pr-1"></i></a>
                    @endcan
                </div>
            </div>
            @if($cate->child->count())
                @include('admin.layouts.category-groups' , [ 'categories' => $cate->child])
            @endif
        </li>
    @endforeach
</ul>

@slot('script')
    <script>
        $('.deleteBtn').on('click',function (e){
            e.preventDefault();
            let deleteBtn = $(this);
            Swal.fire({
                icon: 'warning',
                iconColor: '#ff1e00',
                title: 'آیا از حذف دسته بندی اطمینان دارید؟',
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
                    deleteBtn.siblings('form.deleteCategory').submit();
                }
            });
        })
    </script>
@endslot
