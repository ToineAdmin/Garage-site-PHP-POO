<?php 
namespace App;

class Users{

    public function displayUsers($username){

        echo 
        '<div class="col-lg-4 mx-auto text-center">
            <svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false">
                <title>Placeholder</title>
                <rect width="100%" height="100%" fill="var(--bs-secondary-color)" />
            </svg>
            <h2 class="fw-normal">' . $username . '</h2>
            <p>Some representative placeholder content for the three columns of text below the carousel. This is the first column.</p>
        </div>';

    }

}