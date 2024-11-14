document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.querySelector('.response-box');
    textarea.addEventListener('click', function() {
        this.classList.toggle('expanded');
    });
});

