<?php 

class Car {
    // Properties
    public $id;
    public $brand;
    public $model;
    public $color;
    public $image;
    public $km;
    public $price;
    public $owner_id;

    // Constructor
    public function __construct($id, $brand, $model, $color, $image, $km, $price, $owner_id) {
        $this->id = $id;
        $this->brand = $brand;
        $this->model = $model;
        $this->color = $color;
        $this->image = $image;
        $this->km = $km;
        $this->price = $price;
        $this->owner_id = $owner_id;
    }

    // Additional methods can be added as needed
}

?>