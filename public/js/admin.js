// Anonymize member routine
const anonymizeMemberBtn = document.getElementById('anonymizeMemberBtn');
const anonymizeMemberConfirmBtn = document.getElementById('anonymizeMemberConfirmBtn');
const anonymizeMemberModal = new bootstrap.Modal(document.getElementById('anonymizeMemberModal'));
const anonymizeMemberModalBody = document.querySelector('#anonymizeMemberModal .modal-body');
const chooseMemberForm = document.getElementById('chooseMemberForm');
const chooseMemberFormSelect = chooseMemberForm.querySelector('select');

function showConfirmModal(e) {
    e.preventDefault();
    if (!chooseMemberForm.reportValidity()) {
        return;
    }
    let selectedOptionText = chooseMemberFormSelect.options[chooseMemberFormSelect.selectedIndex].text;
    anonymizeMemberModalBody.innerHTML = 'Opravdu chceš anonymizovat člena &bdquo;' + selectedOptionText + '&ldquo;? Tato akce je nevratná.';
    anonymizeMemberModal.show();
}

anonymizeMemberBtn.addEventListener('click', showConfirmModal);

anonymizeMemberConfirmBtn.addEventListener('click', () => {
    anonymizeMemberBtn.type = 'submit';
    anonymizeMemberBtn.removeEventListener('click', showConfirmModal);
    anonymizeMemberBtn.click();
});
