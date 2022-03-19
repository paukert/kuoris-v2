const navbarItems = document.querySelectorAll('#navbarNav a');

for (let i = 0; i < navbarItems.length; i++) {
    if (navbarItems[i].getAttribute('href') === window.location.pathname) {
        navbarItems[i].classList.add('active');
        navbarItems[i].setAttribute('aria-current', 'page');
        break;
    }
}
