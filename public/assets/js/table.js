const itemActions = document.querySelectorAll('.item-actions i');

itemActions.forEach((item) => {
    item.addEventListener('click', (event) => {
        const dropdown = event.target.closest('.item-actions').querySelector('.item-options');
        dropdown.classList.toggle('active');
    });
});