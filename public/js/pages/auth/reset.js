"use strict";
// validator
var KTSigninGeneral = function() {
    var e, t, i;
    return {
        init: function() {
            e = document.querySelector("#kt_sign_in_form"), 
            t = document.querySelector("#kt_sign_in_submit"), 
            i = FormValidation.formValidation(e, {
                fields: {                    
                    form_password: {
                        validators: {
                            notEmpty: {
                                message: "The password is required"
                            }
                        }
                    },
                    form_password_re: {
                        validators: {
                            notEmpty: {
                                message: "The password is required"
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger,
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "",
                        eleValidClass: ""
                    })
                }
            }), t.addEventListener("click", (function(n) {
                n.preventDefault(), i.validate().then((function(i) {
                    "Valid" == i ? (
                        // disable submit botton
                        t.setAttribute("data-kt-indicator", "on"), 
                        t.disabled = !0,

                        // action auth login
                        actsubmitAuthResetPassword(),                        

                        setTimeout(function() {
                            // reset input password
                            $('#form_password').val(''),
                            $('#form_password_re').val(''),

                            // allow submit botton
                            t.removeAttribute("data-kt-indicator"), 
                            t.disabled = !1
                        }, 2000)

                        ) : Swal.fire({
                        text: "Sorry, looks like there are some errors detected, please try again.",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    })
                }))
            }))
        }
    }
}();

KTUtil.onDOMContentLoaded((function() {
    KTSigninGeneral.init()
}));

function actsubmitAuthResetPassword()
{
    $("#card_alert_informasi").hide(1000);

    let token = $("#form_token").val();
    let password = $("#form_password").val();
    let password_re = $("#form_password_re").val();
    let recaptcha = $(".g-recaptcha-response").val();

    // validasi google captcha
    if(recaptcha == "")
    {
        checkStrength('');
        grecaptcha.reset();
        $("#card_alert_informasi").show(1000);
        $("#alert_informasi").html('Pastikan Anda Bukan Robot, Ceklis Google Captcha..!!');

        Swal.fire({
            text: "Pastikan Anda Bukan Robot, Ceklis Google Captcha..!!",
            icon: "warning",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });        
        return false;
    }

    // validasi form required
    if(password == "" || password_re == "")
    {
        checkStrength('');
        grecaptcha.reset();
        $("#card_alert_informasi").show(1000);
        $("#alert_informasi").html('Pastikan Anda Sudah Mengisi Semua Form Data..!!');
        
        return false;
    }else{
        // validasi password
        if(password != password_re)
        {
            checkStrength('');
            grecaptcha.reset();
            $("#card_alert_informasi").show(1000);
            $("#alert_informasi").html('Password dan Re-Password dipastikan sama..!!');
            
            return false;
        }

        if(checkStrength(password) != 'Strong')
        {
            checkStrength('');
            grecaptcha.reset();
            $("#card_alert_informasi").show(1000);
            $("#alert_informasi").html('Pastikan Password Anda Sudah Cukup Kuat (Srtrong).!!');
            
            return false;
        }
    }    

    // Proses Kirim Data AJAX
    $.ajax({
        url: BaseURL + "/auth/reset/act",
        data: {
            token,
            password,
            recaptcha
        },
        method: "POST",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            grecaptcha.reset();
            
            if(data.status == true)
            {
                Swal.fire({
                    title: 'Berhasil Reset Password',
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
                        window.location.replace(BaseURL + "/auth/login");
                        return false;
                    }
                })
            }else{
                if(data.message == 'Data token invalid' || data.message == 'Token sudah digunakan' || data.message == 'Token sudah expired')
                {
                    location.reload();
                    return false;
                }

                checkStrength('');
                grecaptcha.reset();
                $("#card_alert_informasi").show(1000);
                $("#alert_informasi").html(data.message); 

                return false;
            }
        },
        error: function () {
            checkStrength('');
            grecaptcha.reset();
            Swal.fire({
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

$('#form_password').keyup(function() {
    var password = $('#form_password').val();
    $('#re-password-verif').addClass('text-danger').text('');

    if (checkStrength(password) == 'Strong') 
    {
        $('#kt_sign_in_submit').prop('disabled', false);
    }else{
        $('#kt_sign_in_submit').prop('disabled', true);
    }
});

$('#form_password_re').keyup(function() {
    var password = $('#form_password').val();
    var re_password = $('#form_password_re').val();
    if (password == re_password) 
    {
        $('#re-password-verif').removeClass('text-danger');
        $('#re-password-verif').addClass('text-success').text('Re-Password Sama');
    }else{
        $('#re-password-verif').removeClass('text-success');
        $('#re-password-verif').addClass('text-danger').text('Re-Password Tidak Sama');
    }
});
