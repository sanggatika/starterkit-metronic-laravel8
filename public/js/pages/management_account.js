"use strict";
// validator

var updateManagemntAccount = function() {
    var e, t, i;
    return {
        init: function() {
            e = document.querySelector("#form_management_account"), 
            t = document.querySelector("#btnSubmitUpdateDataAccount"), 
            i = FormValidation.formValidation(e, {
                fields: {                    
                    form_account_name: {
                        validators: {
                            notEmpty: {
                                message: "Nama Account Wajib Di Isi"
                            }
                        }
                    },
                    form_account_handphone: {
                        validators: {
                            notEmpty: {
                                message: "Nomor Handphone Account Wajib Di Isi"
                            }
                        }
                    },
                    form_account_jabatan: {
                        validators: {
                            notEmpty: {
                                message: "Jabatan Account Menu Wajib Di Isi"
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
                        actsubmitUpdateManagementAccount(),                        

                        setTimeout(function() {
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

function actsubmitUpdateManagementAccount()
{
    $("#card_alert_informasi").hide(1000);
    let form_account_uuid = $("#form_account_uuid").val();
    let form_account_name = $("#form_account_name").val();
    let form_account_handphone = $("#form_account_handphone").val();
    let form_account_jabatan = $("#form_account_jabatan").val();
    let recaptcha = $(".g-recaptcha-response").val();

    // validasi google captcha
    if(recaptcha == "")
    {
        grecaptcha.reset();
        $("#card_alert_informasi").show(1000);
        $("#alert_informasi").html('Pastikan Anda Bukan Robot, Ceklis Google Captcha..!!');
       
        return false;
    }

    // validasi form required
    if(form_account_name == "" || form_account_handphone == "" || form_account_jabatan == "")
    {
        grecaptcha.reset();
        $("#card_alert_informasi").show(1000);
        $("#alert_informasi").html('Pastikan Anda Sudah Mengisi Semua Form Data..!!');
        
        return false;
    }

    // Proses Kirim Data AJAX
    $.ajax({
        url: BaseURL + "/management/account/act_edit",
        data: {
            form_account_uuid,
            form_account_name,
            form_account_handphone,
            form_account_jabatan,
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
                    title: 'Berhasil Update !',
                    text: data.message,
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Relode Page',
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
                grecaptcha.reset();
                $("#card_alert_informasi").show(1000);
                $("#alert_informasi").html(data.message); 

                return false;
            }
        },
        error: function () {
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

$('#form_account_pass').bind('keyup blur', function() {
    var password = $(this).val();
    var lowerCaseLetters = /[a-z]/g;
    var upperCaseLetters = /[A-Z]/g;
    var numbers = /[0-9]/g;

    if (password.match(lowerCaseLetters)) {
        $("#lowercase").attr('class', 'svg-icon svg-icon-1 svg-icon-success');
        $("#lowercase").html(`
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black"></rect>
                <path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="black"></path>
            </svg>
        `);
    } else {
        $("#lowercase").attr('class', 'svg-icon svg-icon-1 svg-icon-danger');
        $("#lowercase").html(`
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black"></rect>
                <rect x="7" y="15.3137" width="12" height="2" rx="1" transform="rotate(-45 7 15.3137)" fill="black"></rect>
                <rect x="8.41422" y="7" width="12" height="2" rx="1" transform="rotate(45 8.41422 7)" fill="black"></rect>
            </svg>
        `);
    }

    if (password.match(upperCaseLetters)) {
        $("#uppercase").attr('class', 'svg-icon svg-icon-1 svg-icon-success');
        $("#uppercase").html(`
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black"></rect>
                <path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="black"></path>
            </svg>
        `);
    } else {
        $("#uppercase").attr('class', 'svg-icon svg-icon-1 svg-icon-danger');
        $("#uppercase").html(`
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black"></rect>
                <rect x="7" y="15.3137" width="12" height="2" rx="1" transform="rotate(-45 7 15.3137)" fill="black"></rect>
                <rect x="8.41422" y="7" width="12" height="2" rx="1" transform="rotate(45 8.41422 7)" fill="black"></rect>
            </svg>
        `);
    }

    if (password.match(numbers)) {
        $("#number").attr('class', 'svg-icon svg-icon-1 svg-icon-success');
        $("#number").html(`
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black"></rect>
                <path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="black"></path>
            </svg>
        `);
    } else {
        $("#number").attr('class', 'svg-icon svg-icon-1 svg-icon-danger');
        $("#number").html(`
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black"></rect>
                <rect x="7" y="15.3137" width="12" height="2" rx="1" transform="rotate(-45 7 15.3137)" fill="black"></rect>
                <rect x="8.41422" y="7" width="12" height="2" rx="1" transform="rotate(45 8.41422 7)" fill="black"></rect>
            </svg>
        `);
    }

    if (password.length >= 8) {
        $("#minimum").attr('class', 'svg-icon svg-icon-1 svg-icon-success');
        $("#minimum").html(`
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black"></rect>
                <path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="black"></path>
            </svg>
        `);
    } else {
        $("#minimum").attr('class', 'svg-icon svg-icon-1 svg-icon-danger');
        $("#minimum").html(`
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black"></rect>
                <rect x="7" y="15.3137" width="12" height="2" rx="1" transform="rotate(-45 7 15.3137)" fill="black"></rect>
                <rect x="8.41422" y="7" width="12" height="2" rx="1" transform="rotate(45 8.41422 7)" fill="black"></rect>
            </svg>
        `);
    }
});

var updatepassManagemntAccount = function() {
    var e, t, i;
    return {
        init: function() {
            e = document.querySelector("#form_management_account_pass"), 
            t = document.querySelector("#btnSubmitUpdateDataAccountPass"), 
            i = FormValidation.formValidation(e, {
                fields: {                    
                    form_account_pass_curent: {
                        validators: {
                            notEmpty: {
                                message: "Password Saat Ini Wajib Di Isi"
                            }
                        }
                    },
                    form_account_pass: {
                        validators: {
                            notEmpty: {
                                message: "Password Baru Wajib Di Isi"
                            }
                        }
                    },
                    form_account_pass_konfirm: {
                        validators: {
                            notEmpty: {
                                message: "Konfirmasi Password Wajib Di Isi"
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
                        actsubmitUpdatePassManagementAccount(),                        

                        setTimeout(function() {
                            // allow submit botton

                            // reset input password
                            $('#form_account_pass_curent').val(''),
                            $('#form_account_pass').val(''),
                            $('#form_account_pass_konfirm').val(''),

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

$('#form_account_pass').keyup(function() {
    var password = $('#form_account_pass').val();
    $('#re-password-verif').addClass('text-danger').text('');

    if (checkStrength(password) == 'Strong') 
    {
        $('#btnSubmitUpdateDataAccountPass').prop('disabled', false);
    }else{
        $('#kt_sign_inbtnSubmitUpdateDataAccountPass_submit').prop('disabled', true);
    }
});

$('#form_account_pass_konfirm').keyup(function() {
    var password = $('#form_account_pass').val();
    var re_password = $('#form_account_pass_konfirm').val();
    if (password == re_password) 
    {
        $('#re-password-verif').removeClass('text-danger');
        $('#re-password-verif').addClass('text-success').text('Re-Password Sama');
    }else{
        $('#re-password-verif').removeClass('text-success');
        $('#re-password-verif').addClass('text-danger').text('Re-Password Tidak Sama');
    }
});

function actsubmitUpdatePassManagementAccount()
{
    $("#card_alert_informasi_pass").hide(1000);
    let form_account_uuid = $("#form_account_uuid").val();
    let form_account_pass_curent = $("#form_account_pass_curent").val();
    let form_account_pass = $("#form_account_pass").val();
    let form_account_pass_konfirm = $("#form_account_pass_konfirm").val();

    // validasi form required
    if(form_account_pass_curent == "" || form_account_pass == "" || form_account_pass_konfirm == "")
    {
        $("#card_alert_informasi_pass").show(1000);
        $("#alert_informasi_pass").html('Pastikan Anda Sudah Mengisi Semua Form Data..!!');
        
        return false;
    }else{
        // validasi password
        if(form_account_pass != form_account_pass_konfirm)
        {
            checkStrength('');
            $("#card_alert_informasi_pass").show(1000);
            $("#alert_informasi_pass").html('Password dan Re-Password dipastikan sama..!!');
            
            return false;
        }

        if(checkStrength(form_account_pass) != 'Strong')
        {
            checkStrength('');
            $("#card_alert_informasi_pass").show(1000);
            $("#alert_informasi_pass").html('Pastikan Password Anda Sudah Cukup Kuat (Srtrong).!!');
            
            return false;
        }
    }

    // Proses Kirim Data AJAX
    $.ajax({
        url: BaseURL + "/management/account/act_edit_pass",
        data: {
            form_account_uuid,
            form_account_pass_curent,
            form_account_pass
        },
        method: "POST",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {            
            if(data.status == true)
            {
                Swal.fire({
                    title: 'Berhasil Update !',
                    text: data.message,
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Relode Page',
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
                $("#card_alert_informasi_pass").show(1000);
                $("#alert_informasi_pass").html(data.message);

                return false;
            }
        },
        error: function () {
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

KTUtil.onDOMContentLoaded((function() {
    updateManagemntAccount.init(),
    updatepassManagemntAccount.init()
}));