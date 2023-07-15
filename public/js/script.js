
// Sélectionnez le bouton "Ajouter"
const btnAddUser = document.querySelector('.btn-add-user');

// Sélectionnez le formulaire d'ajout d'utilisateur
const addUserForm = document.querySelector('#add-user-form');


btnAddUser.addEventListener('click', function() {
    // Affiche le formulaire d'ajout d'utilisateur en modifiant son style d'affichage
    addUserForm.style.display = 'block';
    btnAddUser.style.display = 'none';
});


    // SCRIPT POUR CLASS ACTIVE SUR NAV-LINK DANS HEADER 
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