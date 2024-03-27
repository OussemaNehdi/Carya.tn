<?php
class User {
    // Properties
    public $id;
    public $firstName;
    public $lastName;
    public $password;
    public $email;
    public $creation_date;
    public $role;

    // Constructor
    public function __construct($id, $firstName, $lastName, $password, $email, $creation_date, $role) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->password = $password;
        $this->email = $email;
        $this->creation_date = $creation_date;
        $this->role = $role;
    }

    // Methods
    public function getFullName() {
        return $this->firstName . ' ' . $this->lastName;
    }

    // Additional methods can be added as needed
}
?>
