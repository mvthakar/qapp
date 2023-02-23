function showDeleteAnswerConfirmation(id, questionId) {
    $('#btn-yes').attr('data-id', id);
    $('#btn-yes').attr('data-question-id', questionId);
    $('#modal-delete').modal('show');
}

function deleteAnswer() {
    let id = $('#btn-yes').attr('data-id');
    let questionId = $('#btn-yes').attr('data-question-id');
    if (id == null || questionId == null)
        return;

    window.location.href = `../answers/delete.php?id=${id}&questionId=${questionId}`;
}