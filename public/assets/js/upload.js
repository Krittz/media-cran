const fileInput = document.getElementById('file');

fileInput.addEventListener('change', function () {
    const fileName = fileInput.files[0] ? fileInput.files[0].name : "Select file";
    fileInput.nextElementSibling.textContent = fileName;
})