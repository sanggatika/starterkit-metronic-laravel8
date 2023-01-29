function checkStrength(password)
{
    if(password == '')
    {
        $('#result').removeClass()
        $('#password-indikator').addClass('progress-bar-danger');
        $('#result').addClass('text-danger').text('');
        $('#password-strength').css('width', '0%');
    }

    var strength = 0;

    // If password contains both lower and uppercase characters, increase strength value.
    if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) {
        strength += 1;
    }

    // If it has numbers and characters, increase strength value.
    if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) {
        strength += 1;
    }

    // If it has one special character, increase strength value.
    if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) {
        strength += 1;
    }

    // Atleast 8 Character
    if (password.length > 7) {
        strength += 1;
    }

    // If value is less than 2
    if (strength == 1) {
        $('#result').removeClass()
        $('#password-indikator').addClass('progress-bar-danger');
        $('#result').addClass('text-danger').text('Very Week');
        $('#password-strength').css('width', '10%');
        return 'Very Week'
    } else if (strength == 2) {
        $('#result').removeClass()
        $('#result').addClass('good');
        $('#password-indikator').removeClass('progress-bar-danger');
        $('#password-indikator').addClass('progress-bar-warning');
        $('#result').addClass('text-warning').text('Week')
        $('#password-strength').css('width', '30%');
        return 'Week'
    } else if (strength == 3) {
        $('#result').removeClass()
        $('#result').addClass('good');
        $('#password-indikator').removeClass('progress-bar-warning');
        $('#password-indikator').addClass('progress-bar-info');
        $('#result').addClass('text-warning').text('Medium')
        $('#password-strength').css('width', '60%');
        return 'Medium'
    }else if (strength == 4) {
        $('#result').removeClass()
        $('#result').addClass('strong');
        $('#password-indikator').removeClass('progress-bar-info');
        $('#password-indikator').addClass('progress-bar-success');
        $('#result').addClass('text-success').text('Strength');
        $('#password-strength').css('width', '100%');

        return 'Strong'
    }
}

function decryptAES256CBC(data_encrpty)
{
    // Created using Crypt::encryptString('Hello world.') on Laravel.
    // If Crypt::encrypt is used the value is PHP serialized so you'll 
    // need to "unserialize" it in JS at the end.
    var tmp_dataencrpty = data_encrpty;
    var slice_first = tmp_dataencrpty.slice(3);
    var slice_last = slice_first.slice(0, -6);

    var encrypted = slice_last;

    // The APP_KEY in .env file. Note that it is base64 encoded binary
    var key = $('meta[name="csrf-key"]').attr('content');

    try {
        // Laravel creates a JSON to store iv, value and a mac and base64 encodes it.
        // So let's base64 decode the string to get them.
        encrypted = atob(encrypted);
        encrypted = JSON.parse(encrypted);

        // IV is base64 encoded in Laravel, expected as word array in cryptojs
        const iv = CryptoJS.enc.Base64.parse(encrypted.iv);

        // Value (chipher text) is also base64 encoded in Laravel, same in cryptojs
        const value = encrypted.value;

        // Key is base64 encoded in Laravel, word array expected in cryptojs
        key = CryptoJS.enc.Base64.parse(key);

        // Decrypt the value, providing the IV. 
        var decrypted = CryptoJS.AES.decrypt(value, key, {
            iv: iv
        });

        // CryptoJS returns a word array which can be 
        // converted to string like this
        decrypted = decrypted.toString(CryptoJS.enc.Utf8);
    }catch(err) {
        var decrypted = null;
    }

    return decrypted;
}