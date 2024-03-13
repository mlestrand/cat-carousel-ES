<?php 
include '../config/config.php'; 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start(); /* this allows you to save data in $_SESSION */
/* https://www.w3schools.com/php/php_sessions.asp */

/* write PHP functions here */

function getCatBreeds(){

    $form="<form method='GET' action='carousel.php'>";

    $url = "https://api.thecatapi.com/v1/breeds";
    $data= json_decode(file_get_contents($url));
    //var_dump($data);

    $form.="<div class='container'>
    <div class='row'>
    <div class='col-8'>
    <select class='form-select' name='breed'>";


    for ($i=0;$i<count($data);$i++){
        $id = $data[$i]->id;
        $name = $data[$i]->name;
        $form.= "<option value='$id'>$name</option>";
    }

    $form.="
    </select>
    </div>
    <div class='col-4'>
    <button type='submit' class='btn btn-primary'>See cats</button>
    </div>
    </div>
    </div>";

    $form.="</form>";
    return $form; 
}

function getCatImages(){

}

?>