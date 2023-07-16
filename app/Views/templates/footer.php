<footer class="text-body-secondary py-5">

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src="../../../public/js/script.js"></script>
<script>
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


//     //SCRIPT POUR AFFICHER FORMULAIRE DANS LE BACKOFFICE 
//     // Sélectionnez le bouton "Ajouter"
// const btnAddUser = document.querySelector('.btn-add-user');

// // Sélectionnez le formulaire d'ajout d'utilisateur
// const addUserForm = document.querySelector('#add-user-form');


// btnAddUser.addEventListener('click', function() {
//     // Affiche le formulaire d'ajout d'utilisateur en modifiant son style d'affichage
//     addUserForm.style.display = 'block';
//     btnAddUser.style.display = 'none';
// });
</script>

</script>
</body>

</html>