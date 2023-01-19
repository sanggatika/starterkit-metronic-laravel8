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