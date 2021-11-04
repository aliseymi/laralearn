@extends('layouts.app')

@section('script')
    <script>
        $('#sendComment').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var subject_id = button.data('id'); // Extract info from data-* attributes
            var subject_type = button.data('type'); // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        })


        document.querySelector('#sendCommentForm').addEventListener('submit',function (event){
            event.preventDefault();

            // prepare data
            let form = event.target;
            let data = {
                commentable_id: form.querySelector('input[name="commentable_id"]').value,
                commentable_type: form.querySelector('input[name="commentable_type"]').value,
                parent_id: form.querySelector('input[name="parent_id"]').value,
                comment: form.querySelector('textarea[name="comment"]').value,
                "g-recaptcha-response": form.querySelector('textarea[name="g-recaptcha-response"]').value
            }

            // simple validate for comment
            if(data.comment.length === 0){
                Swal.fire({
                    icon: 'error',
                    title: 'توجه',
                    text: 'لطفا متنی را در قسمت پیام دیدگاه وارد کنید!',
                    confirmButtonText: 'متوجه شدم',
                    confirmButtonColor: '#1db847'
                });
                return;
            }

            // validate for recaptcha
            if(grecaptcha.getResponse().length === 0){
                Swal.fire({
                    icon: 'error',
                    title: 'توجه',
                    text: 'لطفا روی من ربات نیستم کلیک کنید!',
                    confirmButtonText: 'متوجه شدم',
                    confirmButtonColor: '#1db847'
                });
                return;
            }

            // when form submit modal will hide
            $('#sendComment').modal('hide');

            // set csrf token header cause method is POST, and Content-Type cause data is json
            $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
                   'Content-Type': 'application/json'
               }
            });

            $.ajax({
                url: '/comments',
                type: 'POST',
                data: JSON.stringify(data),
                success: function (result){

                    form.querySelector('textarea[name="comment"]').value = '';
                    grecaptcha.reset();

                    if(result.status === 'success'){
                        Swal.fire({
                            icon: 'success',
                            text: 'نظر شما با موفقیت ثبت شد',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }else{
                        Swal.fire({
                            icon: 'error',
                            text: 'ثبت نظر با خطا مواجه شد',
                            confirmButtonText: 'متوجه شدم',
                            confirmButtonColor: '#1db847'
                        });
                    }
                }
            });
        });
    </script>
@endsection

@section('content')

    @auth()
    <div class="modal fade" id="sendComment">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ارسال نظر</h5>
                    <button type="button" class="close mr-auto ml-0" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('send.comment') }}" method="POST" id="sendCommentForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="commentable_id" value="{{ $product->id }}">
                        <input type="hidden" name="commentable_type" value="{{ get_class($product) }}">
                        <input type="hidden" name="parent_id" value="0">
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">پیام دیدگاه:</label>
                            <textarea name="comment" class="form-control" id="message-text"></textarea>
                            @if($errors->has('comment'))
                                <span class="text-danger">{{ $errors->first('comment') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <x-recaptcha :has-error="$errors->has('g-recaptcha-response')"/>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">لغو</button>
                        <button type="submit" class="btn btn-primary">ارسال نظر</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endauth

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ $product->title }}
                    </div>

                    <div class="card-body">
                        {{ $product->description }}

                    </div>
                </div>
            </div>
        </div>
                <div class="row">
                    <div class="col">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4 class="mt-4">بخش نظرات</h4>
                            @auth()
                            <span class="btn btn-sm btn-primary" data-toggle="modal" data-target="#sendComment">ثبت نظر جدید</span>
                            @endauth
                        </div>
{{--                        <div class="card">--}}
{{--                            <div class="card-header d-flex justify-content-between">--}}
{{--                                <div class="commenter">--}}
{{--                                    <span>نام نظردهنده</span>--}}
{{--                                    <span class="text-muted">- دو دقیقه قبل</span>--}}
{{--                                </div>--}}
{{--                                <span class="btn btn-sm btn-primary" data-toggle="modal" data-target="#sendComment" data-id="2" data-type="product">پاسخ به نظر</span>--}}
{{--                            </div>--}}

{{--                            <div class="card-body">--}}
{{--                                محصول زیبایه--}}

{{--                                <div class="card mt-3">--}}
{{--                                    <div class="card-header d-flex justify-content-between">--}}
{{--                                        <div class="commenter">--}}
{{--                                            <span>نام نظردهنده</span>--}}
{{--                                            <span class="text-muted">- دو دقیقه قبل</span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <div class="card-body">--}}
{{--                                        محصول زیبایه--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                </div>
    </div>
@endsection
