function processAction(row) {
    if (window.innerWidth > 991) {
        return;
    }
    row.dataset.collapsed === 'true' ? expandRow(row) : collapseRow(row);
}

function expandRow(row) {
    row.dataset.collapsed = 'false';
    let newRow = document.createElement('tr');
    newRow.innerHTML = getRowContent(row);
    row.parentElement.insertBefore(newRow, row.nextElementSibling);
    row.querySelector('.arrow').classList.replace('fa-angle-down', 'fa-angle-up');
}

function collapseRow(row) {
    row.dataset.collapsed = 'true';
    row.nextElementSibling.remove();
    row.querySelector('.arrow').classList.replace('fa-angle-up', 'fa-angle-down');
}

const rows = Array.from(document.getElementsByTagName('tr'));
rows.forEach(row => row.firstElementChild.addEventListener('click', () => processAction(row)));

window.addEventListener('resize', () => {
    if (window.innerWidth < 992) {
        return;
    }

    rows.forEach(row => {
        if (row.dataset.collapsed === 'false') {
            collapseRow(row);
        }
    });
});

function getRowContent(row) {
    const level = row.querySelector('.level');
    const deadline = row.querySelector('.deadline');
    const nearDeadline = deadline.classList.contains('table-danger');
    return `
        <td colspan="6">
            <ul>
                ${level ? `
                    <li class="d-lg-none">
                        <span class="title">Typ:</span>
                        ${level.innerText}
                    </li>
                    ` : ``
                }
                <li class="d-sm-none">
                    <span class="title">Přihlášky do:</span>
                    ${nearDeadline ? `<span class="near-deadline">${deadline.innerText}</span>` : deadline.innerText}
                </li>
                <li class="d-lg-none">
                    <span class="title">Účast:</span>
                    ${row.querySelector('.attendance').innerText}
                </li>
                <li class="d-md-none">
                    <span class="title">Stav:</span>
                    ${row.querySelector('.entry-status').innerText}
                </li>
            </ul>
        </td>
    `;
}
