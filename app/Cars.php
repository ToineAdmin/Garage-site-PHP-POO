<?php
namespace App;

class Cars{
    
    public $title;
    public $brand;
    public $miles;
    public $description;
    public $caracteristics;
    public $equipements;

    /* public function __construct($title, $brand, $miles, $description,$caracteristics,$equipements)
    {
        $this->title = $title;
        $this->brand = $brand;
        $this->miles = $miles;
        $this->description = $description;
        $this->caracteristics = $caracteristics;
        $this->equipements = $equipements;
    }
    */
    /* public function addCars{


    }*/

    public function displayCars($car){
        echo 
        '<div class="col">
            <div class="card shadow-sm">
                <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
                    <title>Placeholder</title>
                    <rect width="100%" height="100%" fill="#55595c" /><text x="50%" y="50%" fill="#eceeef" dy=".3em">' . $car . '</text>
                </svg>
                <div class="card-body">
                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                        </div>
                        <small class="text-body-secondary">9 mins</small>
                    </div>
                </div>
            </div>
        </div>';
    }
}