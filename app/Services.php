<?php 
namespace App;

class Services{

    public function displayServices($reparation){

        echo 
        '<div class="col-md-6 mb-3">
            <div class="h-100 p-5 text-bg-dark rounded-3">
                <h2>' . $reparation . '</h2>
                <p>Swap the background-color utility and add a `.text-*` color utility to mix up the jumbotron look. Then, mix and match with additional component themes and more.</p>
                <button class="btn btn-outline-light" type="button">Example button</button>
            </div>
        </div>';

    }

    public function addServices(){
        
        if (isset($_POST['addService']) && $_POST['addService'] < 25){

        }

    } 

}