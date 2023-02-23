function login() {
    let email = $('#email').val().trim();
    let password = $('#password').val();

    if (email === "" || password === "")
        return;

    $('#btn-submit').attr('disabled', '');
    $('#btn-submit-text').hide();
    $('#btn-submit-text-saved').hide();
    $('#btn-submit-spinner').show();
    $('#message').html('');

    $.ajax({
        method: 'POST',
        url: 'login.php',
        data: {
            email: email,
            password: password
        },
        success: () => {
            $('#btn-submit-text').hide();
            $('#btn-submit-text-saved').show();
            $('#btn-submit-spinner').hide();

            setTimeout(() => window.location.href = './dashboard.php', 1000);
        },
        error: (response) => {
            $('#btn-submit-text').show();
            $('#btn-submit-text-saved').hide();
            $('#btn-submit-spinner').hide();

            $('#btn-submit').removeAttr('disabled');

            let responseText = JSON.parse(response.responseText);
            let error = createErrorMessage(responseText.message);
            $('#message').html(error);
        }
    });
}

function changePassword() {

    let oldPassword = $('#old-password').val();
    let newPassword = $('#new-password').val();
    let confirmPassword = $('#confirm-password').val();

    if (oldPassword === "" || newPassword === "" || confirmPassword === "")
        return;

    if (newPassword != confirmPassword) {
        $('#message').html(createErrorMessage('New passwords do not match!'));
        return;
    }

    $('#btn-submit').attr('disabled', '');
    $('#btn-submit-text').hide();
    $('#btn-submit-text-saved').hide();
    $('#btn-submit-spinner').show();
    $('#message').html('');

    $.ajax({
        method: 'POST',
        url: 'change-password.php',
        data: {
            oldPassword: oldPassword,
            newPassword: newPassword
        },
        success: (response) => {
            $('#btn-submit-text').hide();
            $('#btn-submit-text-saved').show();
            $('#btn-submit-spinner').hide();

            $('#btn-submit-text').show();
            $('#btn-submit-text-saved').hide();
            $('#btn-submit-spinner').hide();

            $('#btn-submit').removeAttr('disabled');

            let message = createSuccessMessage(response.message);
            $('#message').html(message);
        },
        error: (response) => {
            $('#btn-submit-text').show();
            $('#btn-submit-text-saved').hide();
            $('#btn-submit-spinner').hide();

            $('#btn-submit').removeAttr('disabled');

            let responseText = JSON.parse(response.responseText);
            let error = createErrorMessage(responseText.message);
            $('#message').html(error);
        }
    });
}