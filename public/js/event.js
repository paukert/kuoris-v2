const addNewField = (items, itemsHolder, itemsSelect, groupName, addSelectedValue) => {
    let item = document.createElement('div');
    item.classList.add('col-6', 'col-sm-4', 'col-md-3', 'border', 'p-3');
    if (groupName === 'categories') {
        item.classList.add('col-xl-2');
    }
    item.innerHTML = items.dataset.prototype.replace(/__name__/g, items.dataset.index);

    if (addSelectedValue) {
        let input = item.querySelector('#event_' + groupName + '_' + items.dataset.index + '_name');
        input.setAttribute('value', itemsSelect.options[itemsSelect.selectedIndex].text);
    }

    addXMark(item);
    itemsHolder.appendChild(item);
    items.dataset.index++;
};

const addXMark = (item) => {
    const xMark = document.createElement('a');
    xMark.setAttribute('href', '#');
    xMark.classList.add('float-end');
    xMark.innerHTML = '<span class="fa-solid fa-xmark text-danger pe-1"></span>';

    xMark.addEventListener('click', (e) => {
        e.preventDefault();
        item.remove();
    });
    item.prepend(xMark);
}

// Categories management
const categories = document.getElementById('categories');
const categoriesHolder = document.getElementById('categoriesHolder');
const categoriesSelect = document.getElementById('event_categoriesInDatabase');

categoriesHolder.querySelectorAll('.category').forEach((category) => addXMark(category));

document.getElementById('addNewCategory').addEventListener(
    'click',
    () => addNewField(categories, categoriesHolder, categoriesSelect, 'categories', false)
);
document.getElementById('addExistingCategory').addEventListener(
    'click',
    () => addNewField(categories, categoriesHolder, categoriesSelect, 'categories', true)
);
// End - Categories management

// Organizers management
const organizers = document.getElementById('organizers');
const organizersHolder = document.getElementById('organizersHolder');
const organizersSelect = document.getElementById('event_organizersInDatabase');

organizersHolder.querySelectorAll('.organizer').forEach((organizer) => addXMark(organizer));

document.getElementById('addNewOrganizer').addEventListener(
    'click',
    () => addNewField(organizers, organizersHolder, organizersSelect, 'organizers', false)
);
document.getElementById('addExistingOrganizer').addEventListener(
    'click',
    () => addNewField(organizers, organizersHolder, organizersSelect, 'organizers', true)
);
// End - Organizers management
