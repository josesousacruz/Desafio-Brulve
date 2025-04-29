document.addEventListener('DOMContentLoaded', function() {
    const toggleButtons = document.querySelectorAll('.btn-toggle.toggle-sidebar');
    const wrapper = document.querySelector('.wrapper');

    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            wrapper.classList.toggle('sidebar_minimize');
        });
    });
});