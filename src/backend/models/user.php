<?php

class UserModel {
  public $id;
  public $email;
  public $password;
  public $firstName;
  public $lastName;
  public $fn;
  public $course;
  public $specialty;
  public $createdAt;

  function __construct($id, $email, $password, $firstName, $lastName, $fn, $course, $specialty, $createdAt) {
    $this->id = $id;
    $this->email = $email;
    $this->password = $password;
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->fn = $fn;
    $this->course = $course;
    $this->specialty = $specialty;
    $this->createdAt = $createdAt;
  }
}

?>