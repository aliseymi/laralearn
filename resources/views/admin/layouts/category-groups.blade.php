<ul class="list-group list-group-flush">
    @foreach($categories as $cate)
        <li class="list-group-item">
            <div class="d-flex">
                <span>{{ $cate->name }}</span>
                <div class="actions mr-2">
                    <form action="" id="" method="POST">
                        @csrf
                        @method('delete')
                    </form>
                    <a href="#" class="badge badge-danger">حذف</a>
                    <a href="#" class="badge badge-primary">ویرایش</a>
                    <a href="#" class="badge badge-warning">ثبت زیر دسته</a>
                </div>
            </div>
            @if($cate->child->count())
                @include('admin.layouts.category-groups' , [ 'categories' => $cate->child])
            @endif
        </li>
    @endforeach
</ul>
