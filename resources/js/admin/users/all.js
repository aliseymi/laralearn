import Swal from "sweetalert2";

$(function (){
    $('.deleteUser').on('click',function (){
        let deleteBtn = $(this);
        Swal.fire({
            icon: 'warning',
            iconColor: '#ff1e00',
            title: 'آیا از حذف کاربر اطمینان دارید؟',
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
})
