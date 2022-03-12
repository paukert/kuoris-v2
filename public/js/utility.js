const form = document.getElementsByTagName('form')[0];

form.addEventListener('submit', () => {
    const inputs = Array.from(form.getElementsByTagName('input'));

    inputs.forEach((input) => {
        if (input.name && input.type === 'search' && !input.value) {
            input.name = '';
        }
    });
});
