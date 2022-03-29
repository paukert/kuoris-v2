const addCategoryField = (addSelectedValue) => {
    let item = document.createElement('div');
    item.classList.add('col-6', 'col-sm-4', 'col-md-3', 'col-xl-2', 'border', 'p-2');
    item.innerHTML = categories.dataset.prototype.replace(/__name__/g, categories.dataset.index);

    if (addSelectedValue) {
        let input = item.querySelector('#event_categories_' + categories.dataset.index + '_name');
        input.setAttribute('value', categoriesSelect.options[categoriesSelect.selectedIndex].text);
    }

    addDeleteCategoryButton(item);
    categoriesHolder.appendChild(item);
    categories.dataset.index++;
};

const addDeleteCategoryButton = (item) => {
    const deleteCategoryButton = document.createElement('button');
    deleteCategoryButton.setAttribute('type', 'button');
    deleteCategoryButton.classList.add('btn', 'btn-danger', 'btn-sm');
    deleteCategoryButton.innerText = 'Smazat';

    deleteCategoryButton.addEventListener('click', () => item.remove());
    item.appendChild(deleteCategoryButton);
}

const categories = document.getElementById('categories');
const categoriesHolder = document.getElementById('categoriesHolder');
const categoriesSelect = document.getElementById('event_categoriesInDatabase');

categoriesHolder.querySelectorAll('.category').forEach((category) => addDeleteCategoryButton(category));

document.getElementById('addNewCategory').addEventListener('click', () => addCategoryField(false));
document.getElementById('addExistingCategory').addEventListener('click', () => addCategoryField(true));
