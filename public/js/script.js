var menuLinks = document.querySelectorAll('.nav-link');

function updateActiveClass(event) {
    var clickedLink = event.target;

    menuLinks.forEach(function(link) {
        link.classList.remove('active');
    });
    clickedLink.classList.add('active');
}

menuLinks.forEach(function(link) {
    link.addEventListener('click', updateActiveClass);
});