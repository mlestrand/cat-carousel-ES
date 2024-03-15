<?php 
include 'config/config.php'; 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start(); /* this allows you to save data in $_SESSION */
/* https://www.w3schools.com/php/php_sessions.asp */

function getCatBreeds(){

    $key = KEY;

    $form="<form method='GET' action='carousel.php'>";

    $url = "https://api.thecatapi.com/v1/breeds?api_key=".$key;
    $data= json_decode(file_get_contents($url));
    //var_dump($data);

    $form.="<div class='container'>
    <div class='row'>
    <div class='col-8'>
    <select class='form-select' name='breed'>";

    $catIds = array();
    $catNames = array();

    for ($i=0;$i<count($data);$i++){
        $id = $data[$i]->id;
        $catIds[$i] = $id;
        $name = $data[$i]->name; 
        $catNames[$i] = $name;
        $form.= "<option value='$id'>$name</option>";
    }

    $_SESSION['ids'] = $catIds;
    $_SESSION['names'] = $catNames;

    $form.="</select>
    </div>
    <div class='col-4'>
    <button type='submit' class='btn btn-primary'>See cats</button>
    </div>
    </div>
    </div>";

    $form.="</form>";
    return $form; 
}

function getCatImages($catID){
    $key = KEY;
    $url = "https://api.thecatapi.com/v1/images/search?breed_ids=".$catID."&limit=10&api_key=".$key;
    $data= json_decode(file_get_contents($url));
    $imageOne = $data[0]->url;
    $numImages = count($data);
    $carousel = "<div id='carouselExampleIndicators' class='carousel slide' data-bs-ride='carousel' style='width:50%;'>
    <div class='carousel-indicators'>
    <button type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide-to='0' class='active' aria-current='true' aria-label='Slide 1'></button>";
    for ($i=1;$i<$numImages;$i++){
        $carousel.="<button type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide-to='".$i."'aria-label='Slide".$i."'></button>";
    }
    $carousel.=" </div>
    <div class='carousel-inner'>
    <div class='carousel-item active'>
    <img src='".$imageOne."' class='d-block w-100' alt='Image 1'>
    </div>";
    for($i=1;$i<$numImages;$i++){
        $image = $data[$i]->url;
        $carousel.="<div class='carousel-item'>
        <img src='".$image."' class='d-block w-100' alt='Image".$i."'>
      </div>";
    }
    $carousel.="</div>
    <button class='carousel-control-prev' type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide='prev'>
      <span class='carousel-control-prev-icon' aria-hidden='true'></span>
      <span class='visually-hidden'>Previous</span>
    </button>
    <button class='carousel-control-next' type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide='next'>
      <span class='carousel-control-next-icon' aria-hidden='true'></span>
      <span class='visually-hidden'>Next</span>
    </button>
  </div>";
    return $carousel; 
}

?>
