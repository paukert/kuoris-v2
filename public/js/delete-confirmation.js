// Deleting entry
const deleteEntryConfirmBtn = document.getElementById('deleteEntryConfirmBtn');
const entryForm = document.getElementById('entryForm');

deleteEntryConfirmBtn.addEventListener('click', () => {
    const hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('name', 'delete');
    hiddenInput.setAttribute('type', 'hidden');
    entryForm.append(hiddenInput);
    entryForm.submit();
});

// Deleting comment
const deleteCommentConfirmBtn = document.getElementById('deleteCommentConfirmBtn');
const deleteCommentModal = new bootstrap.Modal(document.getElementById('deleteCommentModal'));
const deleteCommentModalBody = document.querySelector('#deleteCommentModal .modal-body');
const deleteCommentLinks = document.querySelectorAll('.deleteCommentLink');

deleteCommentLinks.forEach((link) => link.addEventListener('click', (e) => {
    e.preventDefault();
    deleteCommentModalBody.innerHTML = 'Chceš opravdu odstranit komentář &bdquo;' + e.currentTarget.dataset.commentText + '&ldquo;?';
    deleteCommentModal.show();
    deleteCommentConfirmBtn.link = e.currentTarget.dataset.deleteLink;
}));

deleteCommentConfirmBtn.addEventListener('click', (e) => {
    window.location.href = e.currentTarget.link;
});
