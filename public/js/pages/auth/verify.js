function actsubmitResendVerifikasi()
{  
    let data_token = $('meta[name="csrf-token"]').attr('content');

    // Proses Kirim Data AJAX
    $.ajax({
        url: BaseURL + "/auth/verify/resend",
        data: {
            data_token,
        },
        method: "get",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            if(data.status == true)
            {
                Swal.fire({
                    title: 'Konfirmasi Email !',
                    text: data.message,
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Masuk Aplikasi',
                    confirmButtonClass: 'btn btn-primary',
                    cancelButtonClass: 'btn btn-danger ml-1',
                    buttonsStyling: false,
                    allowOutsideClick: false,
                }).then(function (result) {
                    if (result.value) {
                        /* Read more about isConfirmed, isDenied below */
                        location.reload();
                        return false;
                    }
                })
            }else{
                Swal.fire({
                    title: 'Informasi',
                    text: data.message,
                    icon: "warning",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
                return false;
            }            
        },
        error: function () {
            Swal.fire({
                title: 'Informasi',
                text: "Data Tidak Terkirim, Hubungi Administrator !!",
                icon: "warning",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
            return false;
        }
    });
}