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


    // BOUTON EN SAVOIR PLUS CAR_CARD
    function toggleDetails(button, carId) {
        var card = button.closest('.card');
        var details = card.querySelector('#details_' + carId);

        card.classList.toggle('active');
        details.style.display = card.classList.contains('active') ? 'block' : 'none';
        button.textContent = card.classList.contains('active') ? 'Réduire' : 'En savoir plus';
    }
</script>




</script>
</body>

</html>