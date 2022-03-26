const deleteEntryConfirmBtn = document.getElementById('deleteEntryConfirmBtn');
const entryForm = document.getElementById('entryForm');

deleteEntryConfirmBtn.addEventListener('click', () => {
    const hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('name', 'delete');
    hiddenInput.setAttribute('type', 'hidden');
    entryForm.append(hiddenInput);
    entryForm.submit();
});
