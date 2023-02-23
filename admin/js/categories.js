function createCategory() {

    let name = $('#name').val().trim();
    if (name === "")
        return;

    $('#btn-submit').attr('disabled', '');

    $('#btn-submit-text').hide();
    $('#btn-submit-text-saved').hide();
    $('#btn-submit-spinner').show();
    $('#message').html('');

    let formData = new FormData();
    formData.append('name', name);

    $.ajax({
        method: 'POST',
        url: '../categories/create.php',
        contentType: false,
        processData: false,
        data: formData,
        success: () => {
            $('#btn-submit-text').hide();
            $('#btn-submit-text-saved').show();
            $('#btn-submit-spinner').hide();

            setTimeout(() => window.location.href = '../categories', 1000);
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

function editCategory(id) {
    let name = $('#name').val().trim();
    if (name === "")
        return;

    $('#btn-submit').attr('disabled', '');

    $('#btn-submit-text').hide();
    $('#btn-submit-text-saved').hide();
    $('#btn-submit-spinner').show();
    $('#message').html('');

    let formData = new FormData();
    formData.append('id', id);
    formData.append('name', name);

    $.ajax({
        method: 'POST',
        url: '../categories/edit.php',
        contentType: false,
        processData: false,
        data: formData,
        success: () => {
            $('#btn-submit-text').hide();
            $('#btn-submit-text-saved').show();
            $('#btn-submit-spinner').hide();

            setTimeout(() => window.location.href = '../categories', 1000);
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

function showDeleteCategoryConfirmation(id) {
    $('#btn-yes').attr('data-id', id);
    $('#modal-delete').modal('show');
}

function deleteCategory() {
    let id = $('#btn-yes').attr('data-id');
    if (id == null)
        return;

    window.location.href = '../categories/delete.php?id=' + id;
}