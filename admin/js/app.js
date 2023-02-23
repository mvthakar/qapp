$(function () { $('[data-toggle="tooltip"]').tooltip() })

function createErrorMessage(message) {
    let errorMessage = '<div class="alert alert-danger alert-dismissible fade show" role="alert">' + message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    return errorMessage;
}

function createSuccessMessage(message) {
    let successMessage = '<div class="alert alert-success alert-dismissible fade show" role="alert">' + message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    return successMessage;
}