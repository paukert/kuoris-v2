// Anonymize member routine
const anonymizeMemberBtn = document.getElementById('anonymizeMemberBtn');
const anonymizeMemberConfirmBtn = document.getElementById('anonymizeMemberConfirmBtn');
const anonymizeMemberModal = new bootstrap.Modal(document.getElementById('anonymizeMemberModal'));
const anonymizeMemberModalBody = document.querySelector('#anonymizeMemberModal .modal-body');
const chooseMemberForm = document.getElementById('chooseMemberForm');
const chooseMemberFormSelect = chooseMemberForm.querySelector('select');

anonymizeMemberBtn.addEventListener('click', (e) => {
    e.preventDefault();
    if (!chooseMemberForm.reportValidity()) {
        return;
    }
    let selectedOptionText = chooseMemberFormSelect.options[chooseMemberFormSelect.selectedIndex].text;
    anonymizeMemberModalBody.innerHTML = 'Opravdu chceš anonymizovat člena &bdquo;' + selectedOptionText + '&ldquo;? Tato akce je nevratná.';
    anonymizeMemberModal.show();
});

anonymizeMemberConfirmBtn.addEventListener('click', () => {
    anonymizeMemberBtn.setAttribute('type', 'submit');
    chooseMemberForm.requestSubmit(anonymizeMemberBtn);
});
