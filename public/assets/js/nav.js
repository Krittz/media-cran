const menuBtn = document.querySelector('#btn-menu');

const sidebar = document.querySelector('#sidebar');

menuBtn.addEventListener('click', () => {
    sidebar.classList.toggle('close');
})